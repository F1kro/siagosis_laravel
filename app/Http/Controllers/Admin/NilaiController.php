<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NilaiExport; // Ensure this class exists in the specified namespace
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with(['siswa.kelas', 'mapel', 'guru.user']); // asumsikan guru punya relasi user

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('mapel_id')) {
            $query->where('mapel_id', $request->mapel_id);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $nilai = $query->paginate(15);

        $kelas = Kelas::all();
        $name = Auth::user()->name;
        $mapel = Mapel::all();
        $guru = Guru::with('user')->get();

        return view('admin.nilai.index', compact('nilai', 'kelas', 'mapel', 'guru', 'name'));
    }

    public function laporan(Request $request)
    {
        $filter = $request->only(['search', 'kelas_id', 'mapel_id', 'guru_id', 'semester']);

        return Excel::download(new NilaiExport($filter), 'laporan_nilai_' . date('Ymd') . '.xlsx');
    }

}
