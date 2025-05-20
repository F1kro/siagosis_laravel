<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruMapelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $name = Auth::user()->name;
        $guruMapel = GuruMapel::with(['guru', 'mapel', 'kelas'])
            ->when($search, function($query, $search) {
                return $query->whereHas('guru', function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })->orWhereHas('mapel', function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                });
            })
            ->paginate(10);

        return view('admin.guru-mapel.index', compact('guruMapel', 'search', 'name'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kelas = Kelas::all();

        return view('admin.guru-mapel.create', compact('gurus', 'mapels', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        GuruMapel::create($request->all());

        return redirect()->route('admin.guru-mapel.index')
            ->with('success', 'Guru Mapel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kelas = Kelas::all();

        return view('admin.guru-mapel.edit', compact('guruMapel', 'gurus', 'mapels', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->update($request->all());

        return redirect()->route('admin.guru-mapel.index')
            ->with('success', 'Data Guru Mapel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->delete();

        return redirect()->route('admin.guru-mapel.index')
            ->with('success', 'Data Guru Mapel berhasil dihapus.');
    }
}
