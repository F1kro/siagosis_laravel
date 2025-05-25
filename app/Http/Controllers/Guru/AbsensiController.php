<?php

namespace App\Http\Controllers\Guru;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\GuruMapel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user->guru) {
            abort(403, 'Akun ini tidak terhubung dengan data guru.');
        }
        $guru = $user->guru;

        $guruMapelEntries = GuruMapel::where('guru_id', $guru->id)->get();
        $kelasDiajar = collect();
        foreach ($guruMapelEntries as $entry) {
            $kelas = Kelas::find($entry->kelas_id);
            $mapel = Mapel::find($entry->mapel_id);
            if ($kelas && $mapel) {
                $kelasItem = (object) [
                    'id' => $kelas->id,
                    'nama_kelas' => $kelas->nama_kelas,
                    'pivot' => (object) ['mapel' => $mapel],
                ];
                $kelasDiajar->push($kelasItem);
            }
        }
        $kelasDiajar = $kelasDiajar->unique('id')->sortBy('nama_kelas');

        $kelasWali = $guru->kelas()->get()->sortBy('nama_kelas');

        return view('guru.absensi.dashboard', compact('kelasDiajar', 'kelasWali'));
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
        $tanggal = $request->query('tanggal', Carbon::today()->toDateString());
        $mapelId = $request->query('mapel_id'); // Pastikan ini juga ada di request

        if (!$kelasId) {
            return redirect()->route('guru.absensi.dashboard')->with('error', 'Silakan pilih kelas terlebih dahulu.');
        }

        $selectedKelas = Kelas::find($kelasId);
        if (!$selectedKelas) {
            return redirect()->route('guru.absensi.dashboard')->with('error', 'Kelas tidak ditemukan.');
        }

        $isKelasWali = ($selectedKelas->guru_id == $guru->id);
        $isMengajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                      ->where('kelas_id', $kelasId)
                                      ->exists();

        if (!$isKelasWali && !$isMengajarDiKelas) {
            abort(403, 'Anda tidak memiliki akses ke data absensi kelas ini.');
        }

        $allowedMapelIds = collect();
        if ($isKelasWali) {
            $allowedMapelIds = $selectedKelas->mapel()->pluck('mapel.id');
        } else {
            $allowedMapelIds = GuruMapel::where('guru_id', $guru->id)
                                        ->where('kelas_id', $kelasId)
                                        ->pluck('mapel_id');
        }
        if ($allowedMapelIds->isEmpty()) { $allowedMapelIds = [0]; }

        $query = Absensi::with(['siswa.user', 'kelas', 'mapel']); // Eager load 'mapel'

        $query->where('kelas_id', $kelasId);

        if ($tanggal !== 'all') {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($mapelId) {
            $query->where('mapel_id', $mapelId);
        }
        $query->whereIn('mapel_id', $allowedMapelIds->isEmpty() ? [0] : $allowedMapelIds);

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $absensi = $query->paginate(10);

        $kelasOptions = $guru->kelas()->get()->merge(
                            Kelas::whereIn('id', GuruMapel::where('guru_id', $guru->id)->pluck('kelas_id')->unique())->get()
                        )->unique('id')->sortBy('nama_kelas');

        $mapelOptions = Mapel::whereIn('id', $allowedMapelIds->isEmpty() ? [0] : $allowedMapelIds)
                             ->orderBy('nama')->get();

        return view('guru.absensi.index', compact('absensi', 'name', 'selectedKelas', 'tanggal', 'mapelId', 'kelasOptions', 'mapelOptions'));
    }

    /**
     * Menampilkan form untuk input/edit absensi massal siswa di kelas tertentu.
     */
    public function inputAbsensi(Request $request) // <-- PERBAIKAN DI SINI: Hapus $kelasId, $tanggal
    {
        $user = Auth::user();
        if (!$user->guru) {
            abort(403, 'Akun ini tidak terhubung dengan data guru.');
        }
        $guru = $user->guru;

        $kelasId = $request->query('kelas_id'); // Ambil dari query string
        $tanggal = $request->query('tanggal', Carbon::today()->toDateString()); // Ambil dari query string
        $mapelId = $request->query('mapel_id'); // Ambil dari query string

        if (!$kelasId) {
            return redirect()->route('guru.absensi.dashboard')->with('error', 'Silakan pilih kelas terlebih dahulu untuk menginput absensi.');
        }

        $selectedKelas = Kelas::find($kelasId);
        if (!$selectedKelas) { return redirect()->route('guru.absensi.dashboard')->with('error', 'Kelas tidak ditemukan.'); }

        $isKelasWali = ($selectedKelas->guru_id == $guru->id);
        $isMengajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                      ->where('kelas_id', $kelasId)
                                      ->exists();

        if (!$isKelasWali && !$isMengajarDiKelas) {
            return redirect()->route('guru.absensi.dashboard')->with('error', 'Anda tidak memiliki akses untuk menginput absensi kelas ini.');
        }

        $siswas = $selectedKelas->siswa()->orderBy('nama')->get();

        $existingAbsensi = Absensi::where('kelas_id', $kelasId)
                                  ->whereDate('tanggal', $tanggal)
                                  ->where('mapel_id', $mapelId) // Tambahkan filter mapel_id di sini
                                  ->get()
                                  ->keyBy('siswa_id');

        $formattedExistingAbsensi = [];
        foreach ($existingAbsensi as $siswaId => $absensiRecord) {
            $formattedExistingAbsensi[$siswaId] = [
                'status' => $absensiRecord->status,
                'keterangan' => $absensiRecord->keterangan,
            ];
            $formattedExistingAbsensi[$siswaId . '_status'] = $absensiRecord->status;
            $formattedExistingAbsensi[$siswaId . '_keterangan'] = $absensiRecord->keterangan;
        }

        $mapelOptions = collect();
        if ($isKelasWali) {
            $mapelOptions = $selectedKelas->mapel()->orderBy('nama')->get();
        } else {
            $mapelIdsDiajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                              ->where('kelas_id', $kelasId)
                                              ->pluck('mapel_id');
            $mapelOptions = Mapel::whereIn('id', $mapelIdsDiajarDiKelas)->orderBy('nama')->get();
        }

        return view('guru.absensi.form', compact('siswas', 'selectedKelas', 'tanggal', 'formattedExistingAbsensi', 'mapelOptions', 'mapelId'));
    }

    /**
     * Menyimpan atau memperbarui data absensi secara massal.
     */
    public function store(Request $request) // <-- PERBAIKAN DI SINI: Hapus $kelasId, $tanggal
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'mapel_id' => 'required|exists:mapel,id',
            'absensi_data' => 'required|array',
            'absensi_data.*.siswa_id' => 'required|exists:siswa,id',
            'absensi_data.*.status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'absensi_data.*.keterangan' => 'nullable|string|max:255',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string',
        ]);

        $guru = Auth::user()->guru;
        $kelasId = $request->input('kelas_id'); // Ambil dari input
        $tanggal = $request->input('tanggal'); // Ambil dari input
        $mapelId = $request->input('mapel_id'); // Ambil dari input
        $semester = $request->input('semester');
        $tahunAjaran = $request->input('tahun_ajaran');

        $selectedKelas = Kelas::find($kelasId);
        $isKelasWali = ($selectedKelas->guru_id == $guru->id);
        $isMengajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                      ->where('kelas_id', $kelasId)
                                      ->exists();

        if (!$isKelasWali && !$isMengajarDiKelas) {
            abort(403, 'Anda tidak memiliki akses untuk menyimpan absensi di kelas ini.');
        }

        foreach ($request->absensi_data as $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $data['siswa_id'],
                    'kelas_id' => $kelasId,
                    'tanggal' => $tanggal,
                    'mapel_id' => $mapelId,
                ],
                [
                    'status' => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                    'waktu' => Carbon::now()->toTimeString(),
                ]
            );
        }

        return redirect()->route('guru.absensi.index', ['kelas_id' => $kelasId, 'tanggal' => $tanggal, 'mapel_id' => $mapelId])
            ->with('success', 'Absensi berhasil disimpan.');
    }

    /**
     * Menghapus semua absensi untuk kelas dan tanggal tertentu.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'mapel_id' => 'required|exists:mapel,id',
        ]);

        $guru = Auth::user()->guru;
        $kelasId = $request->input('kelas_id');
        $tanggal = $request->input('tanggal');
        $mapelId = $request->input('mapel_id');

        $selectedKelas = Kelas::find($kelasId);
        $isKelasWali = ($selectedKelas->guru_id == $guru->id);
        $isMengajarDiKelas = GuruMapel::where('guru_id', $guru->id)
                                      ->where('kelas_id', $kelasId)
                                      ->exists();

        if (!$isKelasWali && !$isMengajarDiKelas) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus absensi ini.');
        }

        Absensi::where('kelas_id', $kelasId)
               ->whereDate('tanggal', $tanggal)
               ->where('mapel_id', $mapelId)
               ->delete();

        return redirect()->route('guru.absensi.index', ['kelas_id' => $kelasId, 'tanggal' => $tanggal, 'mapel_id' => $mapelId])
            ->with('success', 'Semua absensi untuk tanggal ini di kelas berhasil dihapus.');
    }
}