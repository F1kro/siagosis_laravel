<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Eager load relasi 'kelas'
        $query = Mapel::with('kelas'); 

        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('kode', 'like', '%' . $request->search . '%');
        }

        $mapel = $query->paginate(10);
        $name = Auth::user()->name;

        return view('admin.mapel.index', compact('mapel', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();

        return view('admin.mapel.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:mapel,kode',
            'nama' => 'required|string|max:225',
            'kkm' => 'required|numeric',
            'jumlah_jam' => 'required|numeric',
            'kelas_id' => 'array|exists:kelas,id',
        ]);

        $mapel = Mapel::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'kkm' => $request->kkm,
            'jumlah_jam' => $request->jumlah_jam,
        ]);

        $mapel->kelas()->sync($request->kelas_id);

        return redirect()->route('admin.mapel.index')->with('success', 'Data mapel berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mapel = Mapel::with('kelas')->findOrFail($id);
        $kelas = Kelas::all();

        return view('admin.mapel.edit', compact('mapel', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:50|unique:mapel,kode,' . $mapel->id,
            'nama' => 'required|string|max:225',
            'kkm' => 'required|numeric',
            'jumlah_jam' => 'required|numeric',
            'kelas_id' => 'array|exists:kelas,id',
        ]);

        $mapel->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'kkm' => $request->kkm,
            'jumlah_jam' => $request->jumlah_jam,
        ]);

        if ($request->filled('kelas_id')) {
            $mapel->kelas()->sync($request->kelas_id);
        } else {
            $mapel->kelas()->detach();
        }

        return redirect()->route('admin.mapel.index')->with('success', 'Data mapel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);

        // Lepas relasi kelas dulu
        $mapel->kelas()->detach();

        $mapel->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Data mapel berhasil dihapus.');
    }
}
