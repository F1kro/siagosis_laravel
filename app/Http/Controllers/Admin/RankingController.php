<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Ranking;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RankingController extends Controller
{
    public function index(): View
    {
        $daftarTahunAjaran = Nilai::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');
        $daftarKelas = Kelas::orderBy('nama_kelas')->get();

        $riwayatRanking = Ranking::select('tahun_ajaran', 'semester', 'kelas_id', DB::raw('count(*) as jumlah_siswa'), DB::raw('MAX(created_at) as tanggal_dibuat'))
            ->with('kelas')
            ->groupBy('tahun_ajaran', 'semester', 'kelas_id')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return view('admin.ranking.index', compact(
            'daftarTahunAjaran',
            'daftarKelas',
            'riwayatRanking'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $tahunAjaran = $request->tahun_ajaran;
        $semester = $request->semester;
        $kelasId = $request->kelas_id;

        Ranking::where('tahun_ajaran', $tahunAjaran)
               ->where('semester', $semester)
               ->where('kelas_id', $kelasId)
               ->delete();

        $nilaiSiswa = Nilai::where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->whereHas('siswa', function ($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->select('siswa_id', DB::raw('SUM(nilai) as total_nilai'), DB::raw('AVG(nilai) as rata_rata_nilai'))
            ->groupBy('siswa_id')
            ->orderBy('total_nilai', 'desc')
            ->get();

        if ($nilaiSiswa->isEmpty()) {
            return back()->with('error', 'Tidak ada data nilai yang bisa diproses untuk periode dan kelas yang dipilih.');
        }

        $rankingsToInsert = [];
        $rank = 1;
        foreach ($nilaiSiswa as $nilai) {
            $rankingsToInsert[] = [
                'siswa_id' => $nilai->siswa_id,
                'kelas_id' => $kelasId,
                'tahun_ajaran' => $tahunAjaran,
                'semester' => $semester,
                'total_nilai' => $nilai->total_nilai,
                'rata_rata_nilai' => $nilai->rata_rata_nilai,
                'ranking_kelas' => $rank++,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Ranking::insert($rankingsToInsert);

        return redirect()->route('admin.ranking.index')->with('success', 'Peringkat berhasil digenerate!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            'kelas_id' => 'required',
        ]);

        Ranking::where('tahun_ajaran', $request->tahun_ajaran)
            ->where('semester', $request->semester)
            ->where('kelas_id', $request->kelas_id)
            ->delete();

        return redirect()->route('admin.ranking.index')->with('success', 'Batch peringkat berhasil dihapus.');
    }
}