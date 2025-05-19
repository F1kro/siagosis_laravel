<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Routing\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        // Get classes where the teacher is a homeroom teacher
        $kelasWali = Kelas::where('wali_kelas_id', Auth::id())->get();

        $query = Absensi::query();

        // Filter by kelas
        if ($request->has('kelas_id') && !empty($request->kelas_id)) {
            $query->where('kelas_id', $request->kelas_id);
        } else if ($kelasWali->count() > 0) {
            // Default to first class if teacher is a homeroom teacher
            $query->where('kelas_id', $kelasWali->first()->id);
        }

        // Filter by tanggal
        if ($request->has('tanggal') && !empty($request->tanggal)) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Default to today
            $query->whereDate('tanggal', date('Y-m-d'));
        }

        $Absensi = $query->get();

        return view('guru.absensi.index', compact('Absensi', 'kelasWali'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guru = Auth::user()->guru;

        // Get classes where the teacher is a homeroom teacher
        $kelasWali = Kelas::where('wali_kelas_id', Auth::id())->get();

        if ($kelasWali->count() == 0) {
            return redirect()->route('guru.absensi.index')
                ->with('error', 'Anda tidak terdaftar sebagai wali kelas.');
        }

        return view('guru.absensi.create', compact('kelasWali'));
    }

    /**
     * Get students by class for AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSiswaByKelas(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($request) {
            $query->where('kelas_id', $request->kelas_id);
        })->get();

        return response()->json($siswa);
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
            'tanggal' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|array',
        ]);

        // Check if attendance already exists for this class and date
        $existingAbsensi = Absensi::where('kelas_id', $request->kelas_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($existingAbsensi) {
            return redirect()->back()
                ->with('error', 'Data Absensi untuk kelas dan tanggal ini sudah ada.')
                ->withInput();
        }

        // Save Absensi for each student
        foreach ($request->status as $siswaId => $status) {
            Absensi::create([
                'siswa_id' => $siswaId,
                'kelas_id' => $request->kelas_id,
                'tanggal' => $request->tanggal,
                'status' => $status,
                'keterangan' => $request->keterangan[$siswaId] ?? null,
                'guru_id' => Auth::user()->guru->id,
            ]);
        }

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Data absensi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Absensi = Absensi::findOrFail($id);

        // Check if the teacher is the homeroom teacher of this class
        $isWaliKelas = Kelas::where('id', $Absensi->kelas_id)
            ->where('wali_kelas_id', Auth::id())
            ->exists();

        if (!$isWaliKelas) {
            return redirect()->route('guru.absensi.index')
                ->with('error', 'Anda tidak memiliki akses ke data absensi ini.');
        }

        return view('guru.absensi.show', compact('absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Absensi = Absensi::findOrFail($id);

        // Check if the teacher is the homeroom teacher of this class
        $isWaliKelas = Kelas::where('id', $Absensi->kelas_id)
            ->where('wali_kelas_id', Auth::id())
            ->exists();

        if (!$isWaliKelas) {
            return redirect()->route('guru.absensi.index')
                ->with('error', 'Anda tidak memiliki akses ke data Absensi ini.');
        }

        return view('guru.Absensi.edit', compact('Absensi'));
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
        $Absensi = Absensi::findOrFail($id);

        // Check if the teacher is the homeroom teacher of this class
        $isWaliKelas = Kelas::where('id', $Absensi->kelas_id)
            ->where('wali_kelas_id', Auth::id())
            ->exists();

        if (!$isWaliKelas) {
            return redirect()->route('guru.absensi.index')
                ->with('error', 'Anda tidak memiliki akses ke data Absensi ini.');
        }

        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string',
        ]);

        $Absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Data Absensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Absensi = Absensi::findOrFail($id);

        // Check if the teacher is the homeroom teacher of this class
        $isWaliKelas = Kelas::where('id', $Absensi->kelas_id)
            ->where('wali_kelas_id', Auth::id())
            ->exists();

        if (!$isWaliKelas) {
            return redirect()->route('guru.absensi.index')
                ->with('error', 'Anda tidak memiliki akses ke data Absensi ini.');
        }

        $Absensi->delete();

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Data Absensi berhasil dihapus.');
    }
}