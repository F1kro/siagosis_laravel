<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TodoList;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $todos = TodoList::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->orderBy('deadline', 'asc')
            ->orderBy('selesai', 'asc')
            ->paginate(7);

        return view('siswa.todolist.index', compact('todos'));
    }

    public function create()
    {
        $mapels = Mapel::orderBy('nama')->get();
        return view('siswa.todolist.create', compact('mapels'));
    }

    public function edit($id)
    {
        $todo = TodoList::where('id', $id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->firstOrFail();

        $mapels = Mapel::orderBy('nama')->get();
        return view('siswa.todolist.edit', compact('todo', 'mapels'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'mapel_id' => 'nullable|exists:mapel,id',
            'deadline' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $siswa = Auth::user()->siswa;

        $siswa->todoList()->create([
            'judul' => $validatedData['judul'],
            'mapel_id' => $validatedData['mapel_id'],
            'deadline' => $validatedData['deadline'],
            'deskripsi' => $validatedData['deskripsi'],
            'selesai' => false,
        ]);

        return redirect()->route('siswa.todolist.index')->with('success', 'Tugas baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $todo = TodoList::where('id', $id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->firstOrFail();

        if ($request->has('toggle_status')) {
            $todo->update(['selesai' => !$todo->selesai]);
            return back()->with('success', 'Status tugas berhasil diperbarui.');
        }

        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'mapel_id' => 'nullable|exists:mapel,id',
            'deadline' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $todo->update($validatedData);

        return redirect()->route('siswa.todolist.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
{
    $todo = TodoList::where('id', $id)
        ->where('siswa_id', Auth::user()->siswa->id)
        ->firstOrFail();

    $todo->delete();

    return back()->with('success', 'Tugas berhasil dihapus.');
}
}
