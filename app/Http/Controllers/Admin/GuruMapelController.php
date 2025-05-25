<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class GuruMapelController extends Controller
{
    /**
     * Menampilkan daftar penugasan Guru-Mapel-Kelas.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $name = Auth::user()->name;

        $guruMapel = GuruMapel::with(['guru', 'mapel', 'kelas'])
            ->when($search, function($query, $search) {
                return $query->whereHas('guru', function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })->orWhereHas('mapel', function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })->orWhereHas('kelas', function($q) use ($search) {
                    $q->where('nama_kelas', 'like', "%$search%");
                });
            })
            ->paginate(10);

        return view('admin.guru-mapel.index', compact('guruMapel', 'search', 'name'));
    }

    public function create()
    {
        $gurus = Guru::all();

        // Mengambil semua kombinasi Mapel dan Kelas dari tabel pivot 'kelas_mapel'
        $mapelKelasRelations = DB::table('kelas_mapel')
                                  ->select('mapel_id', 'kelas_id')
                                  ->get();

        $mapelsWithKelas = collect();
        foreach ($mapelKelasRelations as $relation) {
            $mapel = Mapel::find($relation->mapel_id);
            $kelas = Kelas::find($relation->kelas_id);

            if ($mapel && $kelas) {
                // Membuat ID gabungan (mapel_id_kelas_id) dan nama tampilan
                $combinedId = $mapel->id . '_' . $kelas->id;
                $mapelsWithKelas->push([
                    'id' => $combinedId,
                    'nama_tampil' => $mapel->nama . ' - ' . $kelas->nama_kelas,
                    'mapel_id' => $mapel->id,
                    'kelas_id' => $kelas->id
                ]);
            }
        }

        // Filter opsi di dropdown: Jangan tampilkan kombinasi Mapel-Kelas yang sudah ditugaskan.
        $existingGuruMapels = GuruMapel::all();

        $filteredMapelsWithKelas = collect();
        foreach ($mapelsWithKelas as $mk) {
            $isAssigned = false;
            foreach ($existingGuruMapels as $existingGm) {
                // Cek apakah kombinasi mapel_id dan kelas_id sudah ada di GuruMapel
                if ($existingGm->mapel_id == $mk['mapel_id'] && $existingGm->kelas_id == $mk['kelas_id']) {
                    $isAssigned = true;
                    break;
                }
            }
            if (!$isAssigned) {
                $filteredMapelsWithKelas->push($mk);
            }
        }
        $mapelsWithKelas = $filteredMapelsWithKelas->sortBy('nama_tampil'); // Urutkan untuk tampilan

        return view('admin.guru-mapel.create', compact('gurus', 'mapelsWithKelas'));
    }

    /**
     * Menyimpan penugasan Guru-Mapel-Kelas yang baru dibuat.
     */
    public function store(Request $request)
    {
        // Validasi awal untuk input yang diterima dari form
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_kelas_combined_id' => 'required|string', // Ini adalah gabungan mapel_id_kelas_id
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        // Pisahkan mapel_id dan kelas_id dari combined_id
        list($mapelId, $kelasId) = explode('_', $request->mapel_kelas_combined_id);

        // Tambahkan mapel_id dan kelas_id ke request agar bisa divalidasi dan disimpan
        $request->merge([
            'mapel_id' => $mapelId,
            'kelas_id' => $kelasId,
        ]);

        // Validasi exists untuk mapel_id dan kelas_id yang sudah dipisahkan
        $request->validate([
            'mapel_id' => 'exists:mapel,id',
            'kelas_id' => 'exists:kelas,id',
        ]);

        // Validasi unik untuk kombinasi guru_id, mapel_id, kelas_id, dan tahun_ajaran
        // Ini mencegah duplikasi entri yang sama
        $request->validate([
            'guru_id' => [
                Rule::unique('guru_mapel')->where(function ($query) use ($request) {
                    return $query->where('mapel_id', $request->mapel_id)
                                 ->where('kelas_id', $request->kelas_id)
                                 ->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
        ], [
            'guru_id.unique' => 'Kombinasi Guru, Mata Pelajaran, Kelas, dan Tahun Ajaran sudah ada.',
        ]);

        GuruMapel::create([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        return redirect()->route('admin.guru-mapel.index')
            ->with('success', 'Guru Mapel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $gurus = Guru::all();

        // Mengambil semua kombinasi Mapel dan Kelas dari tabel pivot 'kelas_mapel'
        $mapelKelasRelations = DB::table('kelas_mapel')
                                  ->select('mapel_id', 'kelas_id')
                                  ->get();

        $mapelsWithKelas = collect();
        foreach ($mapelKelasRelations as $relation) {
            $mapel = Mapel::find($relation->mapel_id);
            $kelas = Kelas::find($relation->kelas_id);

            if ($mapel && $kelas) {
                $combinedId = $mapel->id . '_' . $kelas->id;
                $mapelsWithKelas->push([
                    'id' => $combinedId,
                    'nama_tampil' => $mapel->nama . ' - ' . $kelas->nama_kelas,
                    'mapel_id' => $mapel->id,
                    'kelas_id' => $kelas->id
                ]);
            }
        }

        // Filter opsi di dropdown saat edit:
        // Tampilkan semua opsi yang belum ditugaskan, ditambah opsi yang sedang diedit.
        $existingGuruMapels = GuruMapel::all();

        $filteredMapelsWithKelas = collect();
        foreach ($mapelsWithKelas as $mk) {
            $isAssignedToOtherGuru = false;
            foreach ($existingGuruMapels as $existingGm) {
                // Abaikan entri yang sedang diedit (biarkan muncul di dropdown)
                if ($existingGm->id == $guruMapel->id) {
                    continue;
                }

                // Jika kombinasi mapel_id dan kelas_id ini sudah ditugaskan ke guru lain, jangan tampilkan.
                // Atau, jika kombinasi mapel_id dan kelas_id ini sudah ditugaskan ke guru yang sama (tapi bukan entri ini sendiri)
                if ($existingGm->mapel_id == $mk['mapel_id'] && $existingGm->kelas_id == $mk['kelas_id']) {
                    $isAssignedToOtherGuru = true;
                    break;
                }
            }
            if (!$isAssignedToOtherGuru) {
                $filteredMapelsWithKelas->push($mk);
            }
        }
        // Pastikan opsi yang sedang diedit ada di daftar, meskipun sudah ditugaskan
        $currentCombinedId = $guruMapel->mapel_id . '_' . $guruMapel->kelas_id;
        $mapelsWithKelas = $filteredMapelsWithKelas->sortBy('nama_tampil');

        // Pastikan currentCombinedId tetap terpilih di dropdown
        if (!$mapelsWithKelas->contains('id', $currentCombinedId)) {
            $currentMapel = Mapel::find($guruMapel->mapel_id);
            $currentKelas = Kelas::find($guruMapel->kelas_id);
            if ($currentMapel && $currentKelas) {
                $mapelsWithKelas->push([
                    'id' => $currentCombinedId,
                    'nama_tampil' => $currentMapel->nama . ' - ' . $currentKelas->nama_kelas,
                    'mapel_id' => $currentMapel->id,
                    'kelas_id' => $currentKelas->id
                ]);
                $mapelsWithKelas = $mapelsWithKelas->sortBy('nama_tampil');
            }
        }


        return view('admin.guru-mapel.edit', compact('guruMapel', 'gurus', 'mapelsWithKelas', 'currentCombinedId'));
    }

    /**
     * Memperbarui penugasan Guru-Mapel-Kelas.
     */
    public function update(Request $request, $id)
    {
        $guruMapel = GuruMapel::findOrFail($id);

        // Validasi awal
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_kelas_combined_id' => 'required|string',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        // Pisahkan mapel_id dan kelas_id dari combined_id
        list($mapelId, $kelasId) = explode('_', $request->mapel_kelas_combined_id);

        $request->merge([
            'mapel_id' => $mapelId,
            'kelas_id' => $kelasId,
        ]);

        // Validasi exists untuk mapel_id dan kelas_id yang sudah dipisahkan
        $request->validate([
            'mapel_id' => 'exists:mapel,id',
            'kelas_id' => 'exists:kelas,id',
        ]);

        // Validasi unik saat update, mengabaikan record yang sedang diedit
        $request->validate([
            'guru_id' => [
                Rule::unique('guru_mapel')->ignore($guruMapel->id)->where(function ($query) use ($request) {
                    return $query->where('mapel_id', $request->mapel_id)
                                 ->where('kelas_id', $request->kelas_id)
                                 ->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
        ], [
            'guru_id.unique' => 'Kombinasi Guru, Mata Pelajaran, Kelas, dan Tahun Ajaran sudah ada.',
        ]);

        $guruMapel->update([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);

        return redirect()->route('admin.guru-mapel.index')
            ->with('success', 'Data Guru Mapel berhasil diperbarui.');
    }

    /**
     * Menghapus penugasan Guru-Mapel-Kelas.
     */
    public function destroy($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->delete();

        return redirect()->route('admin.guru-mapel.index')
            ->with('success', 'Data Guru Mapel berhasil dihapus.');
    }
}