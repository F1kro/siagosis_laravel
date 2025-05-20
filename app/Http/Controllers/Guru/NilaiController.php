<?php

namespace App\Http\Controllers\Guru;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with(['siswa', 'mapel']);

        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $nilai = $query->paginate(10);
        $name = Auth::user()->name;

        return view('guru.nilai.index', compact('nilai','name'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $mapel = Mapel::all();
        return view('guru.nilai.create', compact('siswa', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jenis_nilai' => 'required|in:Tugas,Ulangan,UTS,UAS',
            'nilai' => 'required|numeric|min:0|max:100',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => ['required', 'regex:/^\d{4}\/\d{4}$/'], // Contoh: 2024/2025
        ]);

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => Auth::id(), // otomatis guru yg login
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Data nilai berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $siswa = Siswa::all();
        $mapel = Mapel::all();

        return view('guru.nilai.edit', compact('nilai', 'siswa', 'mapel'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jenis_nilai' => 'required|in:Tugas,Ulangan,UTS,UAS',
            'nilai' => 'required|numeric|min:0|max:100',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
        ]);

        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $request->mapel_id,
            // Biasanya guru_id tidak diupdate
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Data nilai berhasil dihapus.');
    }
}
