<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of users with filter by role
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role if specified
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(10);
        $name = Auth::user()->name;

        return view('admin.users.index', compact('users', 'name'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,guru,siswa,orangtua',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profiles', 'public');
        }

        $default = [
            'nama' => $request->name,
            'alamat' => 'Alamat default',
        ];

        switch ($request->role) {
            case 'guru':
                $user->guru()->create(array_merge($default, [
                    'nip' => '000000000000000000',
                    'pendidikan_terakhir' => 'S1',
                    'mata_pelajaran' => 'Matematika',
                    'jenis_kelamin' => 'Laki-laki',
                    'tanggal_lahir' => now(),
                    'telepon' => '0000000000',
                    'foto' => $fotoPath,
                ]));
                break;

            case 'siswa':
                $user->siswa()->create(array_merge($default, [
                    'nisn' => '0000000000',
                    'kelas_id' => 1,
                    'jenis_kelamin' => 'Laki-laki',
                    'tanggal_lahir' => now(),
                    'agama' => 'Islam',
                    'tempat_lahir' => 'Kota',
                ]));
                break;

            case 'orangtua':
                $user->orangtua()->create(array_merge($default, [
                    'pekerjaan' => 'Wiraswasta',
                    'siswa_id' => 1,
                    'telepon' => '0000000000',
                ]));
                break;
            case 'admin':
                break;
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan dengan data default.');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::with(['guru', 'siswa', 'orangtua'])->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */

    public function update(Request $request, $id)
    {
        $user = User::with(['guru', 'siswa', 'orangtua'])->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update nama di relasi sesuai kebutuhan (guru, siswa, ortu)
        if ($user->guru) {
            $user->guru->update(['nama' => $request->name]);
        }

        if ($user->siswa) {
            $user->siswa->update(['nama' => $request->name]);
        }

        if ($user->orangtua) {
            $user->orangtua->update(['nama' => $request->name]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User dan data terkait berhasil diperbarui.');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::with(['guru', 'siswa', 'orangtua'])->findOrFail($id);

        // Delete foto if exists
        if ($user->guru && $user->guru->foto) {
            Storage::disk('public')->delete($user->guru->foto);
        } elseif ($user->siswa && $user->siswa->foto) {
            Storage::disk('public')->delete($user->siswa->foto);
        } elseif ($user->orangtua && $user->orangtua->foto) {
            Storage::disk('public')->delete($user->orangtua->foto);
        }

        // Delete profile
        if ($user->guru) {
            $user->guru->delete();
        } elseif ($user->siswa) {
            $user->siswa->delete();
        } elseif ($user->orangtua) {
            $user->orangtua->delete();
        }

        // Delete user
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Toggle user active status
     */

}
