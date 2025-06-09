<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
        public function index(Request $request)
        {
            $query = User::where('role', 'siswa')->with('siswa.kelas'); // ambil user yang punya relasi siswa

            // Filter pencarian
            if ($search = $request->search) {
                $searchTerm = '%'.str_replace(' ', '%', trim($search)).'%';

                $query->where(function($q) use ($searchTerm, $search) {
                    $q->where('name', 'LIKE', $searchTerm)
                      ->orWhereHas('siswa', function($qs) use ($search) {
                          $qs->where('nisn', 'LIKE', '%'.str_replace(' ', '', $search).'%');
                      });
                });
            }

            // Filter kelas
            if ($kelasId = $request->kelas_id) {
                $query->whereHas('siswa.kelas', function($q) use ($kelasId) {
                    $q->where('id', $kelasId);
                });
            }

            $siswa = Siswa::orderBy('created_at', 'desc')->paginate(7);
            $kelas = Kelas::all();
            $name = Auth::user()->name;
            return view('admin.siswa.index', compact('siswa', 'kelas','name'));
        }
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
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
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:siswa',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->nisn . '@siagosis.com', // email default otomatis
            'password' => Hash::make('password'), // password default
            'role' => 'siswa',
        ]);


        // Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa', 'public');
        }

        // Create siswa profile
        $user->siswa()->create([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'kelas_id' => $request->kelas_id,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = User::whereHas('role', function($query) {
            $query->where('name', 'siswa');
        })->findOrFail($id);

        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $kelas = Kelas::all();
    // $siswa = User::with('siswa')->findOrFail($id);
    $siswa = Siswa::where('id', $id)->first();
    if (!$siswa) {
        return back()->with('error', 'Data siswa tidak ditemukan.');
    }

    return view('admin.siswa.edit', compact('kelas', 'siswa'));
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
        // $siswa = User::with('siswa')->findOrFail($id);
        $siswa = Siswa::where('id', $id)->first();

        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:siswa,nisn,' . $siswa->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user
        $siswa->update([
            'name' => $request->nama,
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old file if exists
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $fotoPath = $request->file('foto')->store('siswa', 'public');

            $siswa->update([
                'foto' => $fotoPath,
            ]);
        }

        // Update siswa profile
        $siswa->update([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa = Siswa::where('id', $id)->first();

        // Delete foto if exists
        if ($siswa && $siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        // Delete siswa profile and user
        if (!$siswa) {
            // $siswa->delete();
            return redirect()->route('admin.siswa.index')->with('error', 'Data Siswa tidak ditemukan.');
        }

        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}