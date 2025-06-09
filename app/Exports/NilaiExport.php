<?php

namespace App\Exports;

use App\Models\Nilai;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Nilai::query()->with('siswa.kelas', 'mapel', 'guru');

        if ($this->request->filled('kelas_id') && $this->request->filled('mapel_id') && $this->request->filled('semester') && $this->request->filled('tahun_ajaran')) {
            $query->whereHas('siswa', function($q) {
               $q->where('kelas_id', $this->request->kelas_id);
            });
            $query->where('mapel_id', $this->request->mapel_id)
                  ->where('semester', $this->request->semester)
                  ->where('tahun_ajaran', $this->request->tahun_ajaran);
        } else {
           $query->whereRaw('1 = 0');
        }
       return $query;
    }

    public function headings(): array
    {
        return ['NISN', 'Nama Siswa', 'Kelas', 'Mata Pelajaran', 'Jenis Nilai', 'Nilai', 'Semester', 'Tahun Ajaran', 'Guru Pengampu'];
    }

    public function map($nilai): array
    {
        return [
            $nilai->siswa->nisn ?? 'N/A',
            $nilai->siswa->nama ?? 'N/A',
            $nilai->siswa->kelas->nama_kelas ?? 'N/A',
            $nilai->mapel->nama ?? 'N/A',
            $nilai->jenis_nilai,
            $nilai->nilai,
            $nilai->semester,
            $nilai->tahun_ajaran,
            $nilai->guru->nama ?? 'N/A',
        ];
    }
}