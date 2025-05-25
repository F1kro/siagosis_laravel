<?php

namespace App\Http\Controllers\Guru;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\GuruMapel; // Tambahkan ini jika kamu memiliki model GuruMapel
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    /**
     * Menampilkan dashboard pilihan kelas untuk guru.
     * Ini akan menjadi halaman utama saat mengakses /guru/nilai
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->guru) {
            abort(403, 'Akun ini tidak terhubung dengan data guru.');
        }

        $guru = $user->guru;

        // Mendapatkan kelas yang diajar oleh guru ini
        $kelasDiajarIds = GuruMapel::where('guru_id', $guru->id)
                                   ->pluck('kelas_id')
                                   ->unique();

        $kelasDiajar = Kelas::whereIn('id', $kelasDiajarIds)
                            ->with(['mapel' => function($query) use ($guru) {
                                $query->whereHas('guru', function($q) use ($guru) {
                                    $q->where('guru.id', $guru->id);
                                });
                            }])
                            ->get()
                            ->map(function($kelas) use ($guru) {
                                $mapelDiajarDiKelasIni = $guru->mapel()->wherePivot('kelas_id', $kelas->id)->first();
                                $kelas->pivot = (object)['mapel' => $mapelDiajarDiKelasIni];
                                return $kelas;
                            });

        // PERBAIKAN DI SINI: Gunakan ->get() untuk mendapatkan semua kelas wali
        $kelasWali = $guru->kelas()->get(); // <-- UBAH DARI ->first() MENJADI ->get()

        return view('guru.nilai.dashboard', compact('kelasDiajar', 'kelasWali'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->guru) {
            abort(403, 'Akun ini tidak terhubung dengan data guru.');
        }

        $guru = $user->guru;
        $name = $user->name;

        $kelasId = $request->query('kelas_id');

        if (!$kelasId) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Silakan pilih kelas terlebih dahulu untuk melihat nilai.');
        }

        $selectedKelas = Kelas::find($kelasId);

        if (!$selectedKelas) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Kelas tidak ditemukan.');
        }

        // Tentukan peran guru di kelas yang dipilih
        $isKelasWali = ($selectedKelas->guru_id == $guru->id);
        $isMengajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                        ->where('kelas_id', $kelasId)
                                        ->exists();

        // Validasi akses utama ke kelas:
        // Guru harus menjadi wali kelas ATAU mengajar setidaknya satu mapel di kelas tersebut.
        if (!$isKelasWali && !$isMengajarDiKelas) {
            abort(403, 'Anda tidak memiliki akses ke nilai kelas ini.');
        }

        // --- LOGIKA BARU UNTUK MENENTUKAN MAPEL YANG BOLEH DITAMPILKAN ---
        $mapelIdsToDisplay = collect();

        // Ambil semua mapel yang terdaftar untuk kelas yang dipilih (dari tabel kelas_mapel)
        $mapelIdsInSelectedKelas = $selectedKelas->mapel()->pluck('mapel.id');

        if ($isKelasWali) {
            // JIKA GURU ADALAH WALI KELAS:
            // Dia berhak melihat semua nilai mata pelajaran yang terdaftar di kelas ini.
            $mapelIdsToDisplay = $mapelIdsInSelectedKelas;
        } else {
            // JIKA GURU BUKAN WALI KELAS TAPI MENGAMPU MAPEL DI KELAS INI:
            // Dia hanya berhak melihat nilai mata pelajaran yang dia ajarkan di kelas ini.
            // Kita perlu filter mapel yang dia ajar berdasarkan mapel yang ada di kelas ini.
            $mapelIdsDiajarOlehGuruDiKelas = GuruMapel::where('guru_id', $guru->id)
                                                      ->where('kelas_id', $kelasId)
                                                      ->pluck('mapel_id');

            // Ambil irisan antara mapel yang ada di kelas dengan mapel yang diajar guru
            $mapelIdsToDisplay = $mapelIdsInSelectedKelas->intersect($mapelIdsDiajarOlehGuruDiKelas);
        }

        // Jika tidak ada mapel yang relevan, maka query harus menghasilkan hasil kosong.
        if ($mapelIdsToDisplay->isEmpty()) {
            $mapelIdsToDisplay = [0]; // Set ke array [0] untuk menghindari error query dengan IN() clause kosong
        }

        // Query nilai berdasarkan kelas yang dipilih dan mapel yang relevan
        $query = Nilai::with(['siswa.kelas', 'mapel', 'guru'])
                      ->whereHas('siswa', function ($q) use ($kelasId) {
                          $q->where('kelas_id', $kelasId); // Filter siswa hanya dari kelas yang dipilih
                      })
                      ->whereIn('mapel_id', $mapelIdsToDisplay); // Filter nilai hanya untuk mapel yang relevan

        // Filter nama siswa jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $nilai = $query->paginate(10);

        return view('guru.nilai.index', compact('nilai', 'name', 'selectedKelas'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $guru = $user->guru;
        if (!$guru) {
            abort(403, 'Anda tidak terdaftar sebagai guru.');
        }

        $siswa = collect();
        $mapel = collect();

        $kelasId = $request->query('kelas_id');

        if (!$kelasId) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Silakan pilih kelas terlebih dahulu untuk menambahkan nilai.');
        }

        $kelas = Kelas::find($kelasId);

        if (!$kelas) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Kelas tidak ditemukan.');
        }

        // Tentukan peran guru di kelas ini
        $isKelasWali = ($kelas->guru_id == $guru->id);
        $isMengajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                        ->where('kelas_id', $kelasId)
                                        ->exists();

        // Validasi akses ke kelas
        if (!$isKelasWali && !$isMengajarDiKelas) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Akses ke kelas ini tidak diizinkan.');
        }

        // Ambil siswa dari kelas yang dipilih
        $siswa = $kelas->siswa()->orderBy('nama')->get();

        // Logika pengambilan Mapel berdasarkan peran guru di kelas ini:
        if ($isKelasWali) {
            // Jika guru adalah wali kelas dari kelas yang dipilih, tampilkan SEMUA mapel di kelas tersebut.
            $mapel = $kelas->mapel()->orderBy('nama')->get();
        } else {
            // Jika guru bukan wali kelas TAPI mengajar di kelas ini (sebagai guru mapel biasa),
            // tampilkan HANYA mapel yang dia ampu DI KELAS INI.
            $mapelIdsDiajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                              ->where('kelas_id', $kelasId)
                                              ->pluck('mapel_id');
            $mapel = Mapel::whereIn('id', $mapelIdsDiajarDiKelas)->orderBy('nama')->get();
        }

        return view('guru.nilai.create', compact('siswa', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jenis_nilai' => 'required|in:Tugas,Ulangan,UTS,UAS',
            'nilai' => 'required|numeric|min:0|max:100',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            // Tambahkan validasi untuk kelas_id jika kamu ingin ini wajib
            'kelas_id' => 'sometimes|exists:kelas,id', // Tambahkan ini
        ]);

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => Auth::user()->guru->id,
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        // Redirect kembali ke index dengan kelas_id yang sama
        return redirect()->route('guru.nilai.index', ['kelas_id' => $request->kelas_id])
            ->with('success', 'Data nilai berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);

        $user = Auth::user();
        $guru = $user->guru;
        if (!$guru) {
            abort(403, 'Anda tidak terdaftar sebagai guru.');
        }

        $siswa = collect();
        $mapel = collect();

        // Ambil kelas_id dari nilai yang sedang diedit (prioritas) atau dari URL
        $kelasId = $nilai->siswa->kelas_id ?? $request->query('kelas_id');

        if (!$kelasId) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Silakan pilih kelas terlebih dahulu untuk mengedit nilai.');
        }

        $kelas = Kelas::find($kelasId);

        if (!$kelas) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Kelas tidak ditemukan.');
        }

        // Tentukan peran guru di kelas ini
        $isKelasWali = ($kelas->guru_id == $guru->id);
        $isMengajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                        ->where('kelas_id', $kelasId)
                                        ->exists();

        // Validasi akses ke kelas
        if (!$isKelasWali && !$isMengajarDiKelas) {
            return redirect()->route('guru.nilai.dashboard')->with('error', 'Akses ke kelas ini tidak diizinkan.');
        }

        // Ambil siswa dari kelas yang dipilih
        $siswa = $kelas->siswa()->orderBy('nama')->get();

        // Logika pengambilan Mapel berdasarkan peran guru di kelas ini:
        if ($isKelasWali) {
            // Jika guru adalah wali kelas dari kelas yang dipilih, tampilkan SEMUA mapel di kelas tersebut.
            $mapel = $kelas->mapel()->orderBy('nama')->get();
        } else {
            // Jika guru bukan wali kelas TAPI mengajar di kelas ini (sebagai guru mapel biasa),
            // tampilkan HANYA mapel yang dia ampu DI KELAS INI.
            $mapelIdsDiajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                              ->where('kelas_id', $kelasId)
                                              ->pluck('mapel_id');
            $mapel = Mapel::whereIn('id', $mapelIdsDiajarDiKelas)->orderBy('nama')->get();
        }

        return view('guru.nilai.edit', compact('nilai', 'siswa', 'mapel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jenis_nilai' => 'required|in:Tugas,Ulangan,UTS,UAS',
            'nilai' => 'required|numeric|min:0|max:100',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            // Tambahkan validasi untuk kelas_id
            'kelas_id' => 'sometimes|exists:kelas,id', // Tambahkan ini
        ]);

        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $request->mapel_id,
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        // Redirect kembali ke index dengan kelas_id yang sama
        return redirect()->route('guru.nilai.index', ['kelas_id' => $request->kelas_id])
            ->with('success', 'Data nilai berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        // Ambil kelas_id dari request setelah delete
        $kelasId = $request->input('kelas_id'); // Ambil dari input hidden yang kita kirim dari JS

        // Redirect kembali ke index dengan kelas_id yang sama
        return redirect()->route('guru.nilai.index', ['kelas_id' => $kelasId])
            ->with('success', 'Data nilai berhasil dihapus.');
    }
}