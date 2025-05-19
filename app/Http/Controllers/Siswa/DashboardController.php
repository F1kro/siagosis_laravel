<?php

namespace App\Http\Controllers\Siswa;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void

    /**
     * Show the siswa dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        // Get student's schedule for today
        $jadwalHariIni = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', strtolower(date('l')))
            ->orderBy('jam_mulai')
            ->get();

        // Get recent grades
        $nilaiTerbaru = Nilai::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get attendance statistics
        $totalHadir = Absensi::where('siswa_id', $siswa->id)
            ->where('status', 'hadir')
            ->count();

        $totalIzin = Absensi::where('siswa_id', $siswa->id)
            ->where('status', 'izin')
            ->count();

        $totalSakit = Absensi::where('siswa_id', $siswa->id)
            ->where('status', 'sakit')
            ->count();

        $totalAlpa = Absensi::where('siswa_id', $siswa->id)
            ->where('status', 'alpa')
            ->count();

        $totalAbsensi = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;

        // Calculate percentages
        $persentaseHadir = $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100) : 0;
        $persentaseIzin = $totalAbsensi > 0 ? round(($totalIzin / $totalAbsensi) * 100) : 0;
        $persentaseSakit = $totalAbsensi > 0 ? round(($totalSakit / $totalAbsensi) * 100) : 0;
        $persentaseAlpa = $totalAbsensi > 0 ? round(($totalAlpa / $totalAbsensi) * 100) : 0;

        return view('siswa.dashboard', compact(
            'jadwalHariIni',
            'nilaiTerbaru',
            'persentaseHadir',
            'persentaseIzin',
            'persentaseSakit',
            'persentaseAlpa'
        ));
    }
}