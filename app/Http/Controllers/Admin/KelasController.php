<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
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
        $query = Kelas::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }

        // Filter by tahun ajaran
        if ($request->has('tahun_ajaran') && !empty($request->tahun_ajaran)) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $kelas = $query->paginate(10);

        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guru = User::whereHas('role', function($query) {
            $query->where('name', 'guru');
        })->get();

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
            'tingkat' => 'required|string|max:10',
            'wali_kelas_id' => 'required|exists:users,id',
            'tahun_ajaran' => 'required|string|max:10',
            'kapasitas' => 'required|integer|min:1',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'wali_kelas_id' => $request->wali_kelas_id,
            'tahun_ajaran' => $request->tahun_ajaran,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        $siswa = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->whereHas('siswa', function($query) use ($id) {
            $query->where('kelas_id', $id);
        })->get();

        return view('admin.kelas.show', compact('kelas', 'siswa'));
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
        $guru = User::whereHas('role', function($query) {
            $query->where('name', 'guru');
        })->get();

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
            'tingkat' => 'required|string|max:10',
            'wali_kelas_id' => 'required|exists:users,id',
            'tahun_ajaran' => 'required|string|max:10',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'wali_kelas_id' => $request->wali_kelas_id,
            'tahun_ajaran' => $request->tahun_ajaran,
            'kapasitas' => $request->kapasitas,
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

        // Check if there are students in this class
        $siswaDalamKelas = User::whereHas('siswa', function($query) use ($id) {
            $query->where('kelas_id', $id);
        })->count();

        if ($siswaDalamKelas > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}