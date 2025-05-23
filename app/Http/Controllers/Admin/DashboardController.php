<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;

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
        $recentBerita = Berita::latest()->take(5)->where('status', 'Published')->get();

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'totalMapel', 'recentBerita', 'name'));
    }


}
