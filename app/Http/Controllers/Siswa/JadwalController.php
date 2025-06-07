<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        $jadwalSiswa = collect();

        if ($siswa && $siswa->kelas_id) {
            $semuaJadwal = Jadwal::where('kelas_id', $siswa->kelas_id)
                ->with(['mapel', 'guru'])
                ->orderBy('jam_mulai')
                ->get();

            if ($semuaJadwal->isNotEmpty()) {
                $daftarHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

                $jadwalSiswa = $semuaJadwal->sortBy(function ($jadwal) use ($daftarHari) {
                    return array_search(strtolower($jadwal->hari), $daftarHari);
                })->groupBy(function ($jadwal) {
                    return ucfirst($jadwal->hari);
                });
            }
        }

        return view('siswa.jadwal.index', compact(
            'siswa',
            'jadwalSiswa'
        ));
    }
}