<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
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
        $query = User::where('role', 'guru');

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $name = Auth::user()->name;
        $guru = Guru::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.guru.index', compact('guru', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.guru.create');
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
            'nip' => 'required|string|max:16',
            'nama' => 'required|string|max:225',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'pendidikan_terakhir' => 'required|string|max:16',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:225',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->nip . '@siagosis.com', // email default otomatis
            'password' => Hash::make('password'), // password default
            'role' => 'guru',
        ]);

        // Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru', 'public');
        }

        // Create guru profile
        $user->guru()->create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'telepon' => $request->telepon,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $guru = User::with('guru')->findOrFail($id);
        $guru = Guru::where('id', $id)->first();
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan.');
        }

        return view('admin.guru.edit', compact('guru'));
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
        // $guru = User::with('guru')->findOrFail($id);
        $guru = Guru::where('id', $id)->first();
        if (!$guru) {
            return redirect()->route('admin.guru.index')->with('error', 'Data guru tidak ditemukan.');
        }

        $request->validate([
            'nip' => 'required|string|max:16',
            'nama' => 'required|string|max:225',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'pendidikan_terakhir' => 'required|string|max:16',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:225',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user
        $guru->update([
            'name' => $request->nama,
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old file if exists
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }

            $fotoPath = $request->file('foto')->store('guru', 'public');

            $guru->update([
                'foto' => $fotoPath,
            ]);
        }

        // Update guru profile
        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $guru = User::with('guru')->findOrFail($id);
        $guru = Guru::where('id', $id)->first();

        // Delete foto if exists
        if ($guru && $guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        // Delete guru profile and user
        if (!$guru) {
            // $guru->delete();
            return redirect()->route('admin.guru.index')->with('error', 'Data guru tidak ditemukan.');
        }

        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
