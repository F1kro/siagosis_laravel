<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class JadwalController extends Controller
{
    public function daftarSemuaJadwal(): View
    {
        $guru = Auth::user()->guru;
        $name = Auth::user()->name;

        $semuaJadwalGuru = collect();

        if ($guru) {
            $semuaJadwalGuru = $guru->jadwal()
                                      ->with(['mapel', 'kelas'])
                                      ->orderBy('hari')
                                      ->orderBy('jam_mulai')
                                      ->get();

            if ($semuaJadwalGuru->isNotEmpty()) {
                $daftarHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $semuaJadwalGuru = $semuaJadwalGuru->sortBy(function ($jadwal) use ($daftarHari) {
                    return array_search(ucfirst(strtolower($jadwal->hari)), $daftarHari);
                })->groupBy('hari');
            }
        }

        return view('guru.jadwal.semua', compact(
            'name',          // Opsional, jika ingin menampilkan nama guru
            'guru',          // Opsional, jika perlu data guru lain di view
            'semuaJadwalGuru' // Data semua jadwal guru
        ));
    }
}