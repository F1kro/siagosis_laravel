<?php

namespace App\Http\Controllers\Orangtua;

use Illuminate\Routing\Controller;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the orangtua dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;

        // Get children
        $anak = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($orangtua) {
            $query->where('orangtua_id', $orangtua->id);
        })->get();

        // Get recent grades for all children
        $nilaiTerbaru = collect();

        foreach ($anak as $a) {
            $nilai = Nilai::where('siswa_id', $a->siswa->id)
                ->orderBy('tanggal', 'desc')
                ->take(5)
                ->get();

            $nilaiTerbaru = $nilaiTerbaru->merge($nilai);
        }

        $nilaiTerbaru = $nilaiTerbaru->sortByDesc('tanggal')->take(5);

        // Get recent attendance for all children
        $AbsensiTerbaru = collect();

        foreach ($anak as $a) {
            $Absensi = Absensi::where('siswa_id', $a->siswa->id)
                ->orderBy('tanggal', 'desc')
                ->take(5)
                ->get();

            $AbsensiTerbaru = $AbsensiTerbaru->merge($Absensi);
        }

        $AbsensiTerbaru = $AbsensiTerbaru->sortByDesc('tanggal')->take(5);

        return view('orangtua.dashboard', compact(
            'anak',
            'nilaiTerbaru',
            'AbsensiTerbaru'
        ));
    }
}