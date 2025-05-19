<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Berita::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('kategori', $request->kategori);
        }

        $berita = $query->orderBy('tanggal', 'desc')->paginate(9);

        return view('berita.index', compact('berita'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Get related news
        $beritaTerkait = Berita::where('kategori', $berita->kategori)
            ->where('id', '!=', $berita->id)
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();

        return view('berita.show', compact('berita', 'beritaTerkait'));
    }
}