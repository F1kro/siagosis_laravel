<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use App\Exports\GuruExport;
use App\Exports\OrangtuaExport;
use App\Exports\NilaiExport;
use App\Exports\AbsensiExport;
use App\Exports\JadwalExport;
use App\Exports\MapelExport;
use App\Exports\RankingExport;
use App\Exports\UserExport;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Orangtua;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Ranking;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;


class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function siswa(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new SiswaExport($request), 'laporan_siswa_' . date("Y-m-d") . '.xlsx');
        }

        $query = Siswa::with('kelas', 'user')->orderBy('nama', 'asc');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nisn', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        $siswas = $query->paginate(15)->withQueryString();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('admin.laporan.siswa', compact('siswas', 'kelasList'));
    }

    public function guru(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new GuruExport($request), 'laporan_guru_' . date("Y-m-d") . '.xlsx');
        }

        $query = Guru::with('user', 'guruMapel.mapel', 'guruMapel.kelas')->orderBy('nama', 'asc');
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nip', 'like', '%' . $request->search . '%');
        }
        $gurus = $query->paginate(15)->withQueryString();
        return view('admin.laporan.guru', compact('gurus'));
    }

    public function orangtua(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new OrangtuaExport($request), 'laporan_orangtua_' . date("Y-m-d") . '.xlsx');
        }

        $query = Orangtua::with('siswa.kelas')->orderBy('nama', 'asc');
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhereHas('siswa', function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%');
                });
        }
        $orangtuas = $query->paginate(15)->withQueryString();
        return view('admin.laporan.orangtua', compact('orangtuas'));
    }

    public function nilai(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new NilaiExport($request), 'laporan_nilai_' . date("Y-m-d") . '.xlsx');
        }

        $query = Nilai::with('siswa', 'mapel', 'guru');
        if ($request->filled('kelas_id') && $request->filled('mapel_id') && $request->filled('semester') && $request->filled('tahun_ajaran')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
            $query->where('mapel_id', $request->mapel_id)
                ->where('semester', $request->semester)
                ->where('tahun_ajaran', $request->tahun_ajaran);
        } else {
            $query->whereRaw('1 = 0');
        }
        $nilaiList = $query->paginate(20)->withQueryString();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::orderBy('nama')->get();
        return view('admin.laporan.nilai', compact('nilaiList', 'kelasList', 'mapelList'));
    }

    public function absensi(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new AbsensiExport($request), 'laporan_absensi_' . date("Y-m-d") . '.xlsx');
        }

        $query = Absensi::with('siswa', 'kelas', 'mapel');
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
            if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
                $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
        } else {
            $query->whereRaw('1 = 0');
        }
        $absensiList = $query->orderBy('tanggal', 'desc')->paginate(20)->withQueryString();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('admin.laporan.absensi', compact('absensiList', 'kelasList'));
    }

    public function jadwal(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new JadwalExport($request), 'laporan_jadwal_' . date("Y-m-d") . '.xlsx');
        }

        $query = Jadwal::with('kelas', 'mapel', 'guru');
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }
        $hariOrder = "FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";
        $jadwalList = $query->orderByRaw($hariOrder)->orderBy('jam_mulai', 'asc')->get();
        $jadwalByHari = $jadwalList->groupBy('hari');
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('admin.laporan.jadwal', compact('jadwalByHari', 'kelasList'));
    }

    public function mapel(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new MapelExport($request), 'laporan_mapel_'.date("Y-m-d").'.xlsx');
        }

        $query = Mapel::with('kelas')->orderBy('nama');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
        }
        $mapels = $query->paginate(15)->withQueryString();
        return view('admin.laporan.mapel', compact('mapels'));
    }

    public function ranking(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new RankingExport($request), 'laporan_ranking_' . date("Y-m-d") . '.xlsx');
        }

        $rankingData = [];
        if ($request->filled('kelas_id') && $request->filled('semester') && $request->filled('tahun_ajaran')) {
            $rankingData = Ranking::with(['siswa', 'kelas'])
                ->where('kelas_id', $request->kelas_id)
                ->where('semester', $request->semester)
                ->where('tahun_ajaran', $request->tahun_ajaran)
                ->orderBy('ranking_kelas', 'asc')
                ->get();
        }

        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.laporan.ranking', compact('rankingData', 'kelasList'));
    }

    public function user(Request $request)
    {
        if ($request->get('export') == 'excel') {
            return Excel::download(new UserExport($request), 'laporan_user_' . date("Y-m-d") . '.xlsx');
        }

        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->orderBy('name')->paginate(15)->withQueryString();
        $roles = User::select('role')->whereNotNull('role')->distinct()->get();
        return view('admin.laporan.user', compact('users', 'roles'));
    }
}
