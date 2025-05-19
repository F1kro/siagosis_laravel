<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Routing\Controller;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the guru dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Get classes where the teacher is a homeroom teacher
        $kelasWali = Kelas::where('wali_kelas_id', $user->id)->get();

        // Get teacher's schedule for today
        $jadwalHariIni = Jadwal::where('guru_id', $user->guru->id)
            ->where('hari', strtolower(date('l')))
            ->orderBy('jam_mulai')
            ->get();

        // Get recent grades given by the teacher
        $nilaiTerbaru = Nilai::where('guru_id', $user->guru->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Count total classes taught by the teacher
        $totalKelas = Jadwal::where('guru_id', $user->guru->id)
            ->distinct('kelas_id')
            ->count('kelas_id');

        // Count total subjects taught by the teacher
        $totalMapel = Jadwal::where('guru_id', $user->guru->id)
            ->distinct('mapel_id')
            ->count('mapel_id');

        return view('guru.dashboard', compact(
            'kelasWali',
            'jadwalHariIni',
            'nilaiTerbaru',
            'totalKelas',
            'totalMapel'
        ));
    }
}