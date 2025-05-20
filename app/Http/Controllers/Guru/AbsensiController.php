<?php

namespace App\Http\Controllers\Guru;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class AbsensiController extends Controller
{
    public function index()
    {
        $data = Absensi::with(['siswa', 'kelas'])->latest()->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string',
        ]);

        $absensi = Absensi::updateOrCreate(
            [
                'siswa_id' => $request->siswa_id,
                'tanggal' => $request->tanggal,
            ],
            $request->only('kelas_id', 'status', 'keterangan', 'semester', 'tahun_ajaran')
        );

        return response()->json(['message' => 'Absensi berhasil disimpan', 'data' => $absensi]);
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return response()->json(['message' => 'Absensi berhasil dihapus']);
    }
}
