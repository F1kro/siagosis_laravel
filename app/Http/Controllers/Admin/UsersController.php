<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;

class UsersController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('kelas')->get();
        $siswa = Siswa::with('siswa')->get();;

        return view('admin.users.index',
            compact('kelas', 'siswa')

        );
    }
}
