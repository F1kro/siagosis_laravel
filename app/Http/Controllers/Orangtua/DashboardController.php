<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Berita;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;

        if (!$orangtua || !$orangtua->siswa) {
            return view('orangtua.dashboard-kosong');
        }

        $siswa = $orangtua->siswa()->with('kelas')->first();

        $absensiHariIni = Absensi::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->orderBy('waktu')
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

        $persentaseHadir = $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100) : 0;

        $beritaTerbaru = Berita::latest()->where('status', 'Published')->take(3)->get();

        Carbon::setLocale('id');
        foreach ($beritaTerbaru as $berita) {
            $berita->waktu_relatif = $berita->created_at->diffForHumans();
        }

        return view('orangtua.dashboard', compact(
            'orangtua',
            'siswa',
            'absensiHariIni',
            'nilaiTerbaru',
            'persentaseHadir',
            'beritaTerbaru'
        ));
    }
}