<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru; // Pastikan model Guru di-import
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth; // Pastikan Auth di-import
// use Carbon\Carbon; // Pastikan Carbon di-import untuk formatting waktu

class JadwalController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Eager load relasi untuk ditampilkan di tabel
        $query = Jadwal::with(['kelas', 'mapel', 'guru']);

        // Get filter parameters
        $kelasId = $request->kelas_id;
        $hari = $request->hari;
        $tahunAjaran = $request->tahun_ajaran;
        $semester = $request->semester;

        // Apply filters
        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }
        if ($hari) {
            $query->where('hari', $hari);
        }
        if ($tahunAjaran) {
            $query->where('tahun_ajaran', $tahunAjaran);
        }
        if ($semester) {
            $query->where('semester', $semester);
        }

        // Order results: by custom day order, then by start time
        $jadwal = $query->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu')")
            ->orderBy('jam_mulai')
            ->paginate(15);

        // Get data for filter options
        $kelas = Kelas::all()->sortBy('nama_kelas');

        $hariList = [
            'senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu',
            'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu',
        ];

        $tahunAjaranList = [];
        $currentYear = date('Y');
        for ($i = $currentYear - 3; $i <= $currentYear + 5; $i++) {
            $tahunAjaranList[] = $i . '/' . ($i + 1);
        }

        $semesterList = ['Ganjil', 'Genap'];

        $name = Auth::user()->name;

        return view('admin.jadwal.index', compact(
            'jadwal', 'kelas', 'hariList', 'tahunAjaranList', 'semesterList',
            'kelasId', 'hari', 'tahunAjaran', 'semester', 'name'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all()->sortBy('nama_kelas');
        $mapel = Mapel::all()->sortBy('nama');
        $guru = Guru::all()->sortBy('nama'); // Mengambil semua Guru dari tabel 'guru'

        $hariList = [
            'senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu',
            'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu',
        ];

        $tahunAjaranList = [];
        $currentYear = date('Y');
        for ($i = $currentYear - 3; $i <= $currentYear + 5; $i++) {
            $tahunAjaranList[] = $i . '/' . ($i + 1);
        }
        $semesterList = ['Ganjil', 'Genap'];

        return view('admin.jadwal.create', compact('kelas', 'mapel', 'guru', 'hariList', 'tahunAjaranList', 'semesterList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'guru_id' => 'required|exists:guru,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:50', // Ruangan bisa kosong
            'tahun_ajaran' => 'required|string|max:50',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // LOGIKA PENTING: Mengisi 'ruangan' dengan nama kelas jika kosong di form
        $ruanganToSave = $request->ruangan; // Ambil nilai dari form
        if (empty($ruanganToSave)) { // Jika ruangan kosong atau null
            $selectedKelas = Kelas::find($request->kelas_id);
            if ($selectedKelas) {
                $ruanganToSave = $selectedKelas->nama_kelas; // Gunakan nama kelas sebagai default
            }
        }

        // Check for schedule conflicts for the class
        $conflictingJadwalKelas = Jadwal::where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($conflictingJadwalKelas) {
            return redirect()->back()
                ->with('error', 'Terdapat konflik jadwal untuk kelas ini pada hari dan jam yang sama.')
                ->withInput();
        }

        // Check for teacher schedule conflicts
        $conflictingGuruJadwal = Jadwal::where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($conflictingGuruJadwal) {
            return redirect()->back()
                ->with('error', 'Terdapat konflik jadwal untuk guru ini pada hari dan jam yang sama.')
                ->withInput();
        }

        // Create the schedule record
        Jadwal::create([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan' => $ruanganToSave, // Gunakan nilai ruangan yang sudah diolah
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (Tidak ada show.blade.php, ini bisa diabaikan atau dihapus jika tidak digunakan)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal')); // Pastikan ada view show jika ini diaktifkan
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id); // Eager load jika ada relasi yang ingin ditampilkan

        $kelas = Kelas::all()->sortBy('nama_kelas');
        $mapel = Mapel::all()->sortBy('nama');
        $guru = Guru::all()->sortBy('nama');

        $hariList = [
            'senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu',
            'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu',
        ];

        $tahunAjaranList = [];
        $currentYear = date('Y');
        for ($i = $currentYear - 3; $i <= $currentYear + 5; $i++) {
            $tahunAjaranList[] = $i . '/' . ($i + 1);
        }
        $semesterList = ['Ganjil', 'Genap'];

        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'mapel', 'guru', 'hariList', 'tahunAjaranList', 'semesterList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'guru_id' => 'required|exists:guru,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:50', // Ruangan bisa kosong
            'tahun_ajaran' => 'required|string|max:50',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // LOGIKA PENTING: Mengisi 'ruangan' dengan nama kelas jika kosong di form
        $ruanganToSave = $request->ruangan; // Ambil nilai dari form
        if (empty($ruanganToSave)) { // Jika ruangan kosong atau null
            $selectedKelas = Kelas::find($request->kelas_id);
            if ($selectedKelas) {
                $ruanganToSave = $selectedKelas->nama_kelas; // Gunakan nama kelas sebagai default
            }
        }

        // Check for schedule conflicts (excluding this jadwal)
        $conflictingJadwalKelas = Jadwal::where('id', '!=', $id) // Exclude current jadwal from conflict check
            ->where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($conflictingJadwalKelas) {
            return redirect()->back()
                ->with('error', 'Terdapat konflik jadwal untuk kelas ini pada hari dan jam yang sama.')
                ->withInput();
        }

        // Check for teacher schedule conflicts (excluding this jadwal)
        $conflictingGuruJadwal = Jadwal::where('id', '!=', $id) // Exclude current jadwal from conflict check
            ->where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($conflictingGuruJadwal) {
            return redirect()->back()
                ->with('error', 'Terdapat konflik jadwal untuk guru ini pada hari dan jam yang sama.')
                ->withInput();
        }

        // Update the schedule record
        $jadwal->update([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan' => $ruanganToSave, // Gunakan nilai ruangan yang sudah diolah
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}