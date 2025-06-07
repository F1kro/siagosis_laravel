<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile()
    {
        $user = User::with([
            'guru.kelasWali',
            'siswa.kelas.waliKelas',
            'orangtua.siswa.kelas.waliKelas'
        ])->find(Auth::id());

        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::with(['guru', 'siswa', 'orangtua'])->find(Auth::id());

        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->nama_user,
            'email' => $request->email,
        ]);

        if ($user->isGuru() && $user->guru) {
            $validatedData = $request->validate([
                'nip'               => ['required', 'string', 'max:255', Rule::unique('guru')->ignore($user->guru->id)],
                'nama'              => 'required|string|max:255',
                'telepon'           => 'required|string|max:15',
                'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
                'tanggal_lahir'     => 'required|date',
                'pendidikan_terakhir' => 'required|string|max:255',
                'alamat'            => 'required|string',
            ]);
            $user->guru->update($validatedData);

        } elseif ($user->isSiswa() && $user->siswa) {
            $validatedData = $request->validate([
                'nisn'          => ['required', 'string', 'max:255', Rule::unique('siswa')->ignore($user->siswa->id)],
                'nama'          => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat'        => 'required|string',
                'tanggal_lahir' => 'required|date',
                'tempat_lahir'  => 'required|string|max:255',
                'agama'         => 'required|string|max:255',
            ]);
            $user->siswa->update($validatedData);

        } elseif ($user->isOrangtua() && $user->orangtua) {
            $validatedData = $request->validate([
                'nama'      => 'required|string|max:255',
                'telepon'   => 'required|string|max:15',
                'alamat'    => 'required|string',
                'pekerjaan' => 'nullable|string|max:255',
            ]);
            $user->orangtua->update($validatedData);
        }

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('Password saat ini salah.');
                }
            }],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.profile')->with('success', 'Password berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $user = User::with(['guru', 'siswa'])->find(Auth::id());

        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (($user->isGuru() && $user->guru) || ($user->isSiswa() && $user->siswa)) {
            $path = $request->file('foto')->store('users', 'public');

            $roleData = $user->isGuru() ? $user->guru : $user->siswa;

            if ($roleData->foto) {
                Storage::disk('public')->delete($roleData->foto);
            }

            $roleData->update(['foto' => $path]);

            return redirect()->route('user.profile')->with('success', 'Foto profil berhasil diperbarui.');
        }

        return redirect()->route('user.profile')->with('error', 'Orang Tua tidak dapat mengubah foto profil.');
    }
}