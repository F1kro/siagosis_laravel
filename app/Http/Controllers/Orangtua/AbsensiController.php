<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\GuruMapel;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;

        if (!$orangtua || !$orangtua->siswa) {
            return redirect()->route('orangtua.dashboard')->with('error', 'Data anak tidak terhubung dengan akun Anda.');
        }
        $siswa = $orangtua->siswa;

        $daftarTahun = Absensi::where('siswa_id', $siswa->id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $daftarMapel = Mapel::whereHas('absensi', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })->orderBy('nama')->get();

        $query = Absensi::with('mapel')
            ->where('siswa_id', $siswa->id);

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        if ($request->filled('mapel_id')) {
            $query->where('mapel_id', $request->mapel_id);
        }

        $absensiSiswa = $query->latest('tanggal')->paginate(10)->withQueryString();

        $guruMapelAssignments = GuruMapel::with('guru')
            ->where('kelas_id', $siswa->kelas_id)
            ->get();

        $guruLookup = [];
        foreach ($guruMapelAssignments as $assignment) {
            if ($assignment->guru) {
                $guruLookup[$assignment->mapel_id] = $assignment->guru->nama;
            }
        }

        return view('orangtua.absensi.index', [
            'siswa' => $siswa,
            'absensiSiswa' => $absensiSiswa,
            'guruLookup' => $guruLookup,
            'daftarTahun' => $daftarTahun,
            'daftarMapel' => $daftarMapel,
        ]);
    }
}