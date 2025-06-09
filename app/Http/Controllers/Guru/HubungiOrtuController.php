<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orangtua;

class HubungiOrtuController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $query = Orangtua::query();
        $query->with('siswa');
        $query->whereHas('siswa');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhereHas('siswa', function ($subQuery) use ($keyword) {
                      $subQuery->where('nama', 'like', "%{$keyword}%");
                  });
            });
        }

        $orang_tua = $query->latest()->paginate(15)->appends(['search' => $keyword]);

        return view('guru.hubungi-ortu.index', compact('orang_tua'));
    }
}