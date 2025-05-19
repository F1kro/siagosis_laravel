<?php

namespace App\Http\Controllers\Admin;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrtuController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'orangtua')->with(['orangtua', 'orangtua.siswa']);

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('orangtua', function($q) use ($request) {
                      $q->where('nama', 'like', '%' . $request->search . '%')
                        ->orWhere('telepon', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $name = Auth::user()->name;
        $siswa = Siswa::all();
        $orangtua = $query->paginate(10);

        return view('admin.ortu.index', compact('orangtua', 'name', 'siswa'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        return view('admin.ortu.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:225',
            'pekerjaan' => 'required|string|max:225',
            'telepon' => 'required|string|max:15|unique:orangtua,telepon',
            'alamat' => 'required|string|max:225',
            'siswa_id' => 'required|exists:siswa,id',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->telepon . '@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'orangtua',
        ]);

        $user->orangtua()->create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'siswa_id' => $request->siswa_id,
        ]);

        return redirect()->route('admin.ortu.index')->with('success', 'Data Orang Tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::all();
        $orangtua = User::with('orangtua')->findOrFail($id);

        return view('admin.ortu.edit', compact('orangtua', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $orangtua = User::with('orangtua')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:225',
            'pekerjaan' => 'required|string|max:225',
            'telepon' => 'required|string|max:15|unique:orangtua,telepon,'.$orangtua->orangtua->id,
            'alamat' => 'required|string|max:225',
            'siswa_id' => 'required|exists:siswa,id',
        ]);

        $orangtua->update(['name' => $request->nama]);

        $orangtua->orangtua()->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'siswa_id' => $request->siswa_id,
        ]);

        return redirect()->route('admin.ortu.index')
            ->with('success', 'Data Orang Tua berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $orangtua = User::with('orangtua')->findOrFail($id);

        if ($orangtua->orangtua) {
            $orangtua->orangtua->delete();
        }

        $orangtua->delete();

        return redirect()->route('admin.ortu.index')
            ->with('success', 'Data Orang Tua berhasil dihapus.');
    }
}