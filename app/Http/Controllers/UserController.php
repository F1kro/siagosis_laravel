<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile()
{
    $user = User::with(['guru', 'siswa.kelas', 'orangtua.siswa.kelas'])->find(Auth::id());
    return view('user.profile', compact('user'));
}

    public function updateProfile(Request $request)
    {
        $user = User::with(['guru', 'siswa', 'orangtua'])->find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($user->isGuru() && $user->guru) {
            $user->guru->update([
                'telepon' => $request->phone,
                'tanggal_lahir' => $request->birth_date,
                'alamat' => $request->address,
            ]);
        } elseif ($user->isSiswa() && $user->siswa) {
            $user->siswa->update([
                'telepon' => $request->phone,
                'tanggal_lahir' => $request->birth_date,
                'alamat' => $request->address,
            ]);
        } elseif ($user->isOrangtua() && $user->orangtua) {
            $user->orangtua->update([
                'telepon' => $request->phone,
                'alamat' => $request->address,
            ]);
        }

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.profile')->with('success', 'Password berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $user = User::with(['guru', 'siswa', 'orangtua'])->find(Auth::id());

        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('foto')->store('users', 'public');

        // Hapus foto lama
        if ($user->isGuru() && $user->guru && $user->guru->foto) {
            Storage::disk('public')->delete($user->guru->foto);
            $user->guru->update(['foto' => $path]);
        } elseif ($user->isSiswa() && $user->siswa && $user->siswa->foto) {
            Storage::disk('public')->delete($user->siswa->foto);
            $user->siswa->update(['foto' => $path]);
        } elseif ($user->isOrangtua() && $user->orangtua && $user->orangtua->foto) {
            Storage::disk('public')->delete($user->orangtua->foto);
            $user->orangtua->update(['foto' => $path]);
        }

        return redirect()->route('user.profile')->with('success', 'Foto profil berhasil diperbarui.');
    }
}
