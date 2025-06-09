<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $guru = Auth::user()->guru;
        $name = Auth::user()->name;

        $totalSiswa = 0;
        $totalMapel = 0;
        $totalKelas = 0;
        $kelasIds = collect();
        $jadwalHariIni = collect(); // Inisialisasi jadwal hari ini

        if ($guru) {
            $totalMapel = $guru->mapel()->count();
            $kelasIds = $guru->kelas()->pluck('id');

            if ($kelasIds->isNotEmpty()) {
                $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds->all())->count();
            }

            $totalKelas = $kelasIds->unique()->count();

            // Mengambil jadwal mapel yang diajar hari ini
            $hariIniStr = Carbon::now()->locale('id_ID')->isoFormat('dddd');

            $jadwalHariIni = $guru->jadwal()
                ->where('hari', $hariIniStr)
                ->with(['mapel', 'kelas'])
                ->orderBy('jam_mulai')
                ->get();
        }

        $recentBerita = Berita::where('status', 'Published')
            ->latest()
            ->take(2)
            ->get();

        return view('guru.dashboard', compact(
            'name',
            'totalSiswa',
            'totalMapel',
            'totalKelas',
            'recentBerita',
            'guru',
            'jadwalHariIni'
        ));
    }
}
