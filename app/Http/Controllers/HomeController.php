<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::check()) {
            $user = User::with('role')->find(Auth::id());

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isGuru()) {
                return redirect()->route('guru.dashboard');
            } elseif ($user->isSiswa()) {
                return redirect()->route('siswa.dashboard');
            } elseif ($user->isOrangtua()) {
                return redirect()->route('orangtua.dashboard');
            }
        }

        return view('welcome');
    }
}