<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Siswa::query()->with('kelas')->orderBy('nama', 'asc');

        if ($this->request->filled('search')) {
            $query->where('nama', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $this->request->search . '%');
        }

        if ($this->request->filled('kelas_id')) {
            $query->where('kelas_id', $this->request->kelas_id);
        }

        return $query;
    }

    public function headings(): array
    {
        return ['NISN', 'Nama Siswa', 'Kelas', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Alamat'];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nisn,
            $siswa->nama,
            $siswa->kelas->nama_kelas ?? 'N/A',
            $siswa->jenis_kelamin,
            $siswa->tempat_lahir,
            \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('D MMMM Y'),
            $siswa->agama,
            $siswa->alamat,
        ];
    }
}