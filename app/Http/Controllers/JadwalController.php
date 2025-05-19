<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \App\Models\User::with('role')->find(Auth::id());

        if ($user->isGuru()) {
            // Get teacher's schedule
            $jadwal = Jadwal::where('guru_id', $user->guru->id)
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('hari');

            return view('jadwal.guru', compact('jadwal'));
        } elseif ($user->isSiswa()) {
            // Get student's class schedule
            $jadwal = Jadwal::where('kelas_id', $user->siswa->kelas_id)
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('hari');

            return view('jadwal.siswa', compact('jadwal'));
        } elseif ($user->isAdmin()) {
            // Admin can see all schedules
            return redirect()->route('admin.jadwal.index');
        } else {
            // Redirect orangtua to select a child first
            return redirect()->route('orangtua.anak.index')
                ->with('info', 'Silakan pilih anak untuk melihat jadwal.');
        }
    }
}