<?php

namespace App\Http\Controllers\Siswa;

// use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;


class AbsensiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;

        $query = Absensi::where('siswa_id', $siswa->id);

        // Filter by month
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('created_at', $request->bulan);
        } else {
            // Default to current month
            $query->whereMonth('created_at', date('m'));
        }

        // Filter by year
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('created_at', $request->tahun);
        } else {
            // Default to current year
            $query->whereYear('created_at', date('Y'));
        }

        $Absensi = $query->orderBy('created_at', 'desc')->get();

        // Get attendance statistics
        $totalHadir = $Absensi->where('status', 'hadir')->count();
        $totalIzin = $Absensi->where('status', 'izin')->count();
        $totalSakit = $Absensi->where('status', 'sakit')->count();
        $totalAlpa = $Absensi->where('status', 'alpa')->count();

        $totalAbsensi = $Absensi->count();

        // Calculate percentages
        $persentaseHadir = $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100) : 0;
        $persentaseIzin = $totalAbsensi > 0 ? round(($totalIzin / $totalAbsensi) * 100) : 0;
        $persentaseSakit = $totalAbsensi > 0 ? round(($totalSakit / $totalAbsensi) * 100) : 0;
        $persentaseAlpa = $totalAbsensi > 0 ? round(($totalAlpa / $totalAbsensi) * 100) : 0;

        return view('siswa.Absensi.index', compact(
            'Absensi',
            'persentaseHadir',
            'persentaseIzin',
            'persentaseSakit',
            'persentaseAlpa'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Auth::user()->siswa;

        $Absensi = Absensi::where('siswa_id', $siswa->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('siswa.Absensi.show', compact('Absensi'));
    }
}