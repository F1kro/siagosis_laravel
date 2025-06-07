<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    public function index()
    {
        $name = Auth::user()->name;

        $beritas = Berita::with('user')
                        ->where('status', 'Published')
                        ->latest()
                        ->paginate(5);

        return view('orangtua.berita.index', compact('beritas', 'name'));
    }

    public function show(Berita $beritum)
    {
        if ($beritum->status !== 'Published') {
            abort(404);
        }
        $name = Auth::user()->name;

        $beritaTerkait = Berita::where('status', 'Published')
                                ->where('kategori', $beritum->kategori)
                                ->where('id', '!=', $beritum->id)
                                ->latest()
                                ->take(4)
                                ->get();

        return view('orangtua.berita.show', [
            'berita' => $beritum,
            'beritaTerkait' => $beritaTerkait,
            'name' => $name
        ]);
    }
}