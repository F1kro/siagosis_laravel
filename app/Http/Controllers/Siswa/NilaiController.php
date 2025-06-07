<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Nilai;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->siswa) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }
        $siswa = $user->siswa;

        $daftarTahunAjaran = Nilai::where('siswa_id', $siswa->id)->select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');
        $daftarMapel = Mapel::whereHas('nilai', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })->orderBy('nama')->get();

        $query = Nilai::with('mapel', 'guru')
            ->where('siswa_id', $siswa->id);

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('mapel_id')) {
            $query->where('mapel_id', $request->mapel_id);
        }

        // Gunakan angka kecil untuk paginasi agar mudah dites
        $semuaNilai = $query->latest('created_at')->paginate(10)->withQueryString();

        return view('siswa.nilai.index', [
            'siswa' => $siswa,
            'semuaNilai' => $semuaNilai,
            'daftarTahunAjaran' => $daftarTahunAjaran,
            'daftarMapel' => $daftarMapel,
        ]);
    }
}