<?php

namespace App\Http\Controllers\Orangtua;
use Illuminate\Routing\Controller;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnakController extends Controller
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
    public function index()
    {
        $orangtua = Auth::user()->orangtua;

        $anak = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($orangtua) {
            $query->where('orangtua_id', $orangtua->id);
        })->get();

        return view('orangtua.anak.index', compact('anak'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orangtua = Auth::user()->orangtua;

        $anak = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($orangtua, $id) {
            $query->where('orangtua_id', $orangtua->id)
                  ->where('id', $id);
        })->firstOrFail();

        return view('orangtua.anak.show', compact('anak'));
    }

    /**
     * Display the child's grades.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nilai($id, Request $request)
    {
        $orangtua = Auth::user()->orangtua;

        $anak = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($orangtua, $id) {
            $query->where('orangtua_id', $orangtua->id)
                  ->where('id', $id);
        })->firstOrFail();

        $query = Nilai::where('siswa_id', $anak->siswa->id);

        // Filter by mapel
        if ($request->has('mapel_id') && !empty($request->mapel_id)) {
            $query->where('mapel_id', $request->mapel_id);
        }

        // Filter by jenis nilai
        if ($request->has('jenis_nilai') && !empty($request->jenis_nilai)) {
            $query->where('jenis_nilai', $request->jenis_nilai);
        }

        $nilai = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('orangtua.anak.nilai', compact('anak', 'nilai'));
    }

    /**
     * Display the child's attendance.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Absensi($id, Request $request)
    {
        $orangtua = Auth::user()->orangtua;

        $anak = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($orangtua, $id) {
            $query->where('orangtua_id', $orangtua->id)
                  ->where('id', $id);
        })->firstOrFail();

        $query = Absensi::where('siswa_id', $anak->siswa->id);

        // Filter by month
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('tanggal', $request->bulan);
        } else {
            // Default to current month
            $query->whereMonth('tanggal', date('m'));
        }

        // Filter by year
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('tanggal', $request->tahun);
        } else {
            // Default to current year
            $query->whereYear('tanggal', date('Y'));
        }

        $Absensi = $query->orderBy('tanggal', 'desc')->get();

        // Get attendance statistics
        $totalHadir = $Absensi->where('status', 'hadir')->count();
        $totalIzin = $Absensi->where('status', 'izin')->count();
        $totalSakit = $Absensi->where('status', 'sakit')->count();
        $totalAlpa = $Absensi->where('status', 'alpa')->count();

        $totalAbsensi = $Absensi->count();

        // Calculate percentages
        $persentaseHadir = $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100) : 0;
        $persentaseIzin = $totalAbsensi > 0 ? round(($totalIzin / $totalAbsensi) * 100) : 0;
        $persentaseSakit = $totalAbsensi > 0 ? round(($totalSakit / $totalAbsensi) * 100) : 0;
        $persentaseAlpa = $totalAbsensi > 0 ? round(($totalAlpa / $totalAbsensi) * 100) : 0;

        return view('orangtua.anak.Absensi', compact(
            'anak',
            'Absensi',
            'persentaseHadir',
            'persentaseIzin',
            'persentaseSakit',
            'persentaseAlpa'
        ));
    }

    /**
     * Display the child's schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jadwal($id)
    {
        $orangtua = Auth::user()->orangtua;

        $anak = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($orangtua, $id) {
            $query->where('orangtua_id', $orangtua->id)
                  ->where('id', $id);
        })->firstOrFail();

        $jadwal = Jadwal::where('kelas_id', $anak->siswa->kelas_id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('orangtua.anak.jadwal', compact('anak', 'jadwal'));
    }
}