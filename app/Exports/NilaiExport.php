<?php
namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = Nilai::with(['siswa', 'mapel', 'guru']);

        if (!empty($this->filter['search'])) {
            $query->whereHas('siswa', function ($q) {
                $q->where('nama', 'like', '%' . $this->filter['search'] . '%');
            });
        }

        if (!empty($this->filter['kelas_id'])) {
            $query->whereHas('siswa', function ($q) {
                $q->where('kelas_id', $this->filter['kelas_id']);
            });
        }

        if (!empty($this->filter['mapel_id'])) {
            $query->where('mapel_id', $this->filter['mapel_id']);
        }

        if (!empty($this->filter['guru_id'])) {
            $query->where('guru_id', $this->filter['guru_id']);
        }

        if (!empty($this->filter['semester'])) {
            $query->where('semester', $this->filter['semester']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Mata Pelajaran',
            'Guru',
            'Jenis Nilai',
            'Nilai',
            'Semester',
            'Tahun Ajaran',
        ];
    }

    public function map($nilai): array
    {
        return [
            $nilai->siswa->nama ?? '',
            $nilai->siswa->kelas->nama ?? '',
            $nilai->mapel->nama ?? '',
            $nilai->guru->nama ?? ($nilai->guru->user->name ?? ''),
            $nilai->jenis_nilai,
            $nilai->nilai,
            $nilai->semester,
            $nilai->tahun_ajaran,
        ];
    }
}
