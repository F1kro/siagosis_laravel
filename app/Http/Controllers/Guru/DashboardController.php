<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $guru = Auth::user()->guru;
        $name = Auth::user()->name;

        $totalSiswa = 0;
        $totalMapel = 0;
        if ($guru) {
            // Total mapel yang dia ajar
            $totalMapel = $guru->mapel()->count();

            // Total siswa di semua kelas yang dia ampu
            $kelasIds = $guru->kelas()->pluck('id');
            $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();
        }

        // Berita terbaru yang ditujukan untuk guru
        $recentBerita = Berita::where('status', 'Published') // misal ada kolom audience untuk target berita
                            ->latest()
                            ->take(5)
                            ->get();

        return view('guru.dashboard', compact('name', 'totalSiswa', 'totalMapel', 'recentBerita', 'guru'));
    }
}
