<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('user')->latest()->paginate(10);
        $name = Auth::user()->name;
        return view('admin.berita.index', compact('berita', 'name'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'konten' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'konten' => $request->konten,
            'foto' => $path,
            'user_id' => Auth::id(),
            'status' => 'Unpublish',
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(Berita $beritum) // single is beritum
    {
        $berita = $beritum;
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $beritum)
    {
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('berita', 'public');
            $beritum->foto = $path;
        }

        $beritum->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ]);

        $beritum->update($request->only(['judul', 'konten', 'kategori', 'status']));

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function showdetail($id)
    {
        $berita = Berita::with('user')->findOrFail($id);
        return view('admin.berita.showdetail', compact('berita'));
    }

    public function accept($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->status = 'Published';
        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil Published.');
    }

    public function destroy(Berita $beritum)
    {
        $beritum->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => asset('storage/' . $path),
            ]);
        }

        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Upload gagal.']]);
    }

}
