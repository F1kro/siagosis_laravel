<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalGuru = Guru::count();
        $name = Auth::user()->name;
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();

        $recentBerita = Berita::latest()->where('status', 'Published')->take(5)->get();

        Carbon::setLocale('id');
        foreach ($recentBerita as $berita) {
            $berita->waktu_relatif = $berita->created_at->diffForHumans();
        }

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'totalMapel', 'recentBerita', 'name'));
    }
}