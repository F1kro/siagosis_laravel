<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RankingController extends Controller
{
    public function index(Request $request): View
    {
        $guru = Auth::user()->guru;

        // Ambil SEMUA kelas dimana guru ini menjadi wali kelas
        $daftarKelasWali = $guru->kelasWali()->orderBy('nama_kelas')->get();

        $rankings = collect();
        $daftarTahunAjaran = collect();
        $daftarSemester = collect();
        $kelasTerpilih = null;

        if ($daftarKelasWali->isNotEmpty()) {
            // Ambil kelas_id dari request, atau default ke kelas pertama dalam daftar
            $idKelasTerpilih = $request->input('kelas_id', $daftarKelasWali->first()->id);
            $kelasTerpilih = $daftarKelasWali->find($idKelasTerpilih);

            // Ambil data untuk dropdown filter berdasarkan kelas yang dipilih
            $daftarTahunAjaran = Ranking::where('kelas_id', $idKelasTerpilih)->select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');
            $daftarSemester = Ranking::where('kelas_id', $idKelasTerpilih)->select('semester')->distinct()->pluck('semester');

            // Ambil filter tahun dan semester dari request, atau default ke yang terbaru
            $filterTahun = $request->input('tahun_ajaran', $daftarTahunAjaran->first());
            $filterSemester = $request->input('semester', $daftarSemester->first());

            $query = Ranking::with('siswa')
                ->where('kelas_id', $idKelasTerpilih);

            if ($filterTahun) {
                $query->where('tahun_ajaran', $filterTahun);
            }
            if ($filterSemester) {
                $query->where('semester', $filterSemester);
            }

            $rankings = $query->orderBy('ranking_kelas', 'asc')->paginate(30)->withQueryString();
        }

        return view('guru.ranking.index', compact(
            'guru',
            'kelasTerpilih',
            'rankings',
            'daftarKelasWali',
            'daftarTahunAjaran',
            'daftarSemester'
        ));
    }
}