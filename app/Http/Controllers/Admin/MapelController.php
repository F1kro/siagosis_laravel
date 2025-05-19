<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Mapel::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                  ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        $mapel = $query->paginate(10);

        return view('admin.mapel.index', compact('mapel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:mapel',
            'nama' => 'required|string|max:100',
            'kelompok' => 'required|string|max:50',
            'tingkat' => 'required|string|max:50',
            'kkm' => 'required|integer|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Mapel::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'kelompok' => $request->kelompok,
            'tingkat' => $request->tingkat,
            'kkm' => $request->kkm,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mapel = Mapel::findOrFail($id);

        return view('admin.mapel.show', compact('mapel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);

        return view('admin.mapel.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:mapel,kode,' . $id,
            'nama' => 'required|string|max:100',
            'kelompok' => 'required|string|max:50',
            'tingkat' => 'required|string|max:50',
            'kkm' => 'required|integer|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $mapel->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'kelompok' => $request->kelompok,
            'tingkat' => $request->tingkat,
            'kkm' => $request->kkm,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);

        // Check if there are related records
        if ($mapel->jadwal()->count() > 0 || $mapel->nilai()->count() > 0) {
            return redirect()->route('admin.mapel.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki data terkait.');
        }

        $mapel->delete();

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}