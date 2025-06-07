<?php

namespace App\Http\Controllers\Siswa;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\TodoList;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan untuk user ini.');
        }

        $siswa = $user->siswa;

        $daftarHari = [
            'monday'    => 'senin',
            'tuesday'   => 'selasa',
            'wednesday' => 'rabu',
            'thursday'  => 'kamis',
            'friday'    => 'jumat',
            'saturday'  => 'sabtu',
            'sunday'    => 'minggu',
        ];
        $hariIniInggris = strtolower(now()->format('l'));
        $hariIniIndonesia = $daftarHari[$hariIniInggris] ?? '';

        $jadwalHariIni = Jadwal::with(['mapel', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIniIndonesia)
            ->orderBy('jam_mulai')
            ->get();

        $nilaiTerbaru = Nilai::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->take(5)
            ->get();

        $statistikAbsensi = Absensi::where('siswa_id', $siswa->id)
            ->select(DB::raw('LOWER(status) as status_lower'), DB::raw('count(*) as total'))
            ->groupBy('status_lower')
            ->pluck('total', 'status_lower');

        $totalHadir = $statistikAbsensi['hadir'] ?? 0;
        $totalIzin = $statistikAbsensi['izin'] ?? 0;
        $totalSakit = $statistikAbsensi['sakit'] ?? 0;
        $totalAlpa = $statistikAbsensi['alpa'] ?? 0;

        $totalAbsensi = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;

        $persentase = [
            'hadir' => $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100) : 0,
            'izin'  => $totalAbsensi > 0 ? round(($totalIzin / $totalAbsensi) * 100) : 0,
            'sakit' => $totalAbsensi > 0 ? round(($totalSakit / $totalAbsensi) * 100) : 0,
            'alpa'  => $totalAbsensi > 0 ? round(($totalAlpa / $totalAbsensi) * 100) : 0,
        ];

        $todoList = TodoList::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->orderBy('selesai', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('siswa.dashboard', [
            'siswa' => $siswa,
            'jadwalHariIni' => $jadwalHariIni,
            'nilaiTerbaru' => $nilaiTerbaru,
            'persentase' => $persentase,
            'todoList' => $todoList,
            'totalAbsensi' => $totalAbsensi, 
        ]);
    }
}