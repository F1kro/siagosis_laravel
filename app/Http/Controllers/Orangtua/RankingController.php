<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RankingController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;

        if (!$orangtua || !$orangtua->siswa) {
            return view('orangtua.ranking.kosong');
        }

        $siswa = $orangtua->siswa;

        $riwayatRanking = Ranking::where('siswa_id', $siswa->id)
            ->with('kelas')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();
            
        foreach ($riwayatRanking as $ranking) {
            $totalSiswaDiKelas = Ranking::where('tahun_ajaran', $ranking->tahun_ajaran)
                ->where('semester', $ranking->semester)
                ->where('kelas_id', $ranking->kelas_id)
                ->count();
            $ranking->total_siswa_di_kelas = $totalSiswaDiKelas;
        }

        return view('orangtua.ranking.index', [
            'siswa' => $siswa,
            'riwayatRanking' => $riwayatRanking,
        ]);
    }
}