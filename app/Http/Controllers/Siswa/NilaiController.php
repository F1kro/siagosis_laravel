<?php

namespace App\Http\Controllers\Siswa;

// use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

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
        $siswa = Auth::user()->siswa;

        $query = Nilai::where('siswa_id', $siswa->id);

        // Filter by mapel
        if ($request->has('mapel_id') && !empty($request->mapel_id)) {
            $query->where('mapel_id', $request->mapel_id);
        }

        // Filter by jenis nilai
        if ($request->has('jenis_nilai') && !empty($request->jenis_nilai)) {
            $query->where('jenis_nilai', $request->jenis_nilai);
        }

        // Filter by semester
        if ($request->has('semester') && !empty($request->semester)) {
            $query->where('semester', $request->semester);
        }

        $nilai = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get mapel for filter options
        $mapel = Mapel::all();

        return view('siswa.nilai.index', compact('nilai', 'mapel'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Auth::user()->siswa;

        $nilai = Nilai::where('siswa_id', $siswa->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('siswa.nilai.show', compact('nilai'));
    }

    /**
     * Display the student's report card.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rapor(Request $request)
    {
        $siswa = Auth::user()->siswa;

        // Default to current semester if not specified
        $semester = $request->semester ?? 'ganjil';
        $tahunAjaran = $request->tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1);

        // Get all subjects
        $mapel = Mapel::all();

        // Get nilai for each subject
        $nilaiMapel = [];

        foreach ($mapel as $m) {
            $tugas = Nilai::where('siswa_id', $siswa->id)
                ->where('mapel_id', $m->id)
                ->where('jenis_nilai', 'tugas')
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->avg('nilai');

            $uh = Nilai::where('siswa_id', $siswa->id)
                ->where('mapel_id', $m->id)
                ->where('jenis_nilai', 'ulangan_harian')
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->avg('nilai');

            $uts = Nilai::where('siswa_id', $siswa->id)
                ->where('mapel_id', $m->id)
                ->where('jenis_nilai', 'uts')
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->avg('nilai');

            $uas = Nilai::where('siswa_id', $siswa->id)
                ->where('mapel_id', $m->id)
                ->where('jenis_nilai', 'uas')
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->avg('nilai');

            // Calculate final grade
            $nilaiAkhir = 0;
            $pembagi = 0;

            if ($tugas) {
                $nilaiAkhir += $tugas * 0.2;
                $pembagi += 0.2;
            }

            if ($uh) {
                $nilaiAkhir += $uh * 0.3;
                $pembagi += 0.3;
            }

            if ($uts) {
                $nilaiAkhir += $uts * 0.2;
                $pembagi += 0.2;
            }

            if ($uas) {
                $nilaiAkhir += $uas * 0.3;
                $pembagi += 0.3;
            }

            if ($pembagi > 0) {
                $nilaiAkhir = $nilaiAkhir / $pembagi;
            }

            $nilaiMapel[] = [
                'mapel' => $m,
                'tugas' => $tugas,
                'uh' => $uh,
                'uts' => $uts,
                'uas' => $uas,
                'nilai_akhir' => $nilaiAkhir,
                'predikat' => $this->getNilaiPredikat($nilaiAkhir),
            ];
        }

        return view('siswa.nilai.rapor', compact('nilaiMapel', 'semester', 'tahunAjaran'));
    }

    /**
     * Get grade predicate based on score.
     *
     * @param  float  $nilai
     * @return string
     */
    private function getNilaiPredikat($nilai)
    {
        if ($nilai >= 90) {
            return 'A';
        } elseif ($nilai >= 80) {
            return 'B';
        } elseif ($nilai >= 70) {
            return 'C';
        } elseif ($nilai >= 60) {
            return 'D';
        } else {
            return 'E';
        }
    }
}