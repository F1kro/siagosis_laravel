<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Kelas::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }

        // Filter by tahun ajaran
        if ($request->has('tahun_ajaran') && !empty($request->tahun_ajaran)) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $kelas = $query->paginate(7);
        $name = Auth::user()->name;

        return view('admin.kelas.index', compact('kelas','name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guru = Guru::all();
        return view('admin.kelas.create', compact('guru'));
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
            'nama_kelas' => 'required|string|max:50',
            'kode_kelas' => 'required|string|max:10|unique:kelas,kode_kelas',
            'guru_id' => 'exists:guru,id',
            'tahun_ajaran' => 'required|string|max:10',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kode_kelas' => $request->kode_kelas,
            'guru_id' => $request->guru_id,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $guru = Guru::all();

        return view('admin.kelas.edit', compact('kelas', 'guru'));
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
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'kode_kelas' => 'required|string|max:10|unique:kelas,kode_kelas,' . $kelas->id,
            'guru_id' => '|exists:guru,id',
            'tahun_ajaran' => 'required|string|max:10',
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'kode_kelas' => $request->kode_kelas,
            'guru_id' => $request->guru_id,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}