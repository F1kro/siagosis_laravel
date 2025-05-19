<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Routing\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
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

        $query = Nilai::where('guru_id', $guru->id);

        // Filter by kelas
        if ($request->has('kelas_id') && !empty($request->kelas_id)) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by mapel
        if ($request->has('mapel_id') && !empty($request->mapel_id)) {
            $query->where('mapel_id', $request->mapel_id);
        }

        // Filter by jenis nilai
        if ($request->has('jenis_nilai') && !empty($request->jenis_nilai)) {
            $query->where('jenis_nilai', $request->jenis_nilai);
        }

        $nilai = $query->orderBy('tanggal', 'desc')->paginate(10);

        // Get kelas and mapel for filter options
        $kelas = Kelas::all();
        $mapel = Mapel::all();

        return view('guru.nilai.index', compact('nilai', 'kelas', 'mapel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guru = Auth::user()->guru;

        // Get kelas and mapel that the teacher teaches
        $kelas = Kelas::whereHas('jadwal', function($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $mapel = Mapel::whereHas('jadwal', function($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        return view('guru.nilai.create', compact('kelas', 'mapel'));
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
            'mapel_id' => 'required|exists:mapel,id',
            'jenis_nilai' => 'required|in:tugas,ulangan_harian,uts,uas',
            'tanggal' => 'required|date',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $guru = Auth::user()->guru;

        // Save nilai for each student
        foreach ($request->nilai as $siswaId => $nilaiValue) {
            Nilai::create([
                'siswa_id' => $siswaId,
                'guru_id' => $guru->id,
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $request->mapel_id,
                'jenis_nilai' => $request->jenis_nilai,
                'nilai' => $nilaiValue,
                'tanggal' => $request->tanggal,
            ]);
        }

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guru = Auth::user()->guru;

        $nilai = Nilai::where('guru_id', $guru->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('guru.nilai.show', compact('nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guru = Auth::user()->guru;

        $nilai = Nilai::where('guru_id', $guru->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('guru.nilai.edit', compact('nilai'));
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
        $guru = Auth::user()->guru;

        $nilai = Nilai::where('guru_id', $guru->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $nilai->update([
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guru = Auth::user()->guru;

        $nilai = Nilai::where('guru_id', $guru->id)
            ->where('id', $id)
            ->firstOrFail();

        $nilai->delete();

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }
}
