<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = \App\Models\User::with('role')->find(Auth::id());

        return view('user.profile', compact('user'));
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = \App\Models\User::with('role')->find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update role-specific profile
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

        return redirect()->route('user.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = \App\Models\User::with('role')->find(Auth::id());

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Update the user's profile picture.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        $user = \App\Models\User::with('role')->find(Auth::id());

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old file if exists
            if ($user->isGuru() && $user->guru && $user->guru->foto) {
                Storage::disk('public')->delete($user->guru->foto);
            } elseif ($user->isSiswa() && $user->siswa && $user->siswa->foto) {
                Storage::disk('public')->delete($user->siswa->foto);
            } elseif ($user->isOrangtua() && $user->orangtua && $user->orangtua->foto) {
                Storage::disk('public')->delete($user->orangtua->foto);
            }

            $path = $request->file('foto')->store('users', 'public');

            // Update role-specific profile
            if ($user->isGuru() && $user->guru) {
                $user->guru->update([
                    'foto' => $path,
                ]);
            } elseif ($user->isSiswa() && $user->siswa) {
                $user->siswa->update([
                    'foto' => $path,
                ]);
            } elseif ($user->isOrangtua() && $user->orangtua) {
                $user->orangtua->update([
                    'foto' => $path,
                ]);
            }
        }

        return redirect()->route('user.profile')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }
}
