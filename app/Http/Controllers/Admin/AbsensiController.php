<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request
        $kelasId = $request->kelas_id; 
        $status = $request->status;
        $semester = $request->semester;
        $tahunAjaran = $request->tahun_ajaran;
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        // Query absensi dengan filter
        $query = Absensi::with(['siswa', 'kelas']);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($semester) {
            $query->where('semester', $semester);
        }

        if ($tahunAjaran) {
            $query->where('tahun_ajaran', $tahunAjaran);
        }

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->paginate(20);

        // Untuk filter dropdown
        $kelas = Kelas::all();
        $name = Auth::user()->name;

        return view('admin.absensi.index', compact('absensi', 'kelas', 'name'));
    }

    public function laporan(Request $request)
{
    // Bisa kirim filter ke export class
    return Excel::download(new AbsensiExport($request->all()), 'laporan-absensi.xlsx');
}
}
