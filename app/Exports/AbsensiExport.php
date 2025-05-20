<?php
namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Absensi::with(['siswa', 'kelas']);

        if (!empty($this->filters['search'])) {
            $query->whereHas('siswa', function($q) {
                $q->where('nama', 'like', '%'.$this->filters['search'].'%');
            });
        }

        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }

        if (!empty($this->filters['semester'])) {
            $query->where('semester', $this->filters['semester']);
        }

        if (!empty($this->filters['tahun_ajaran'])) {
            $query->where('tahun_ajaran', $this->filters['tahun_ajaran']);
        }

        if (!empty($this->filters['tanggal_awal']) && !empty($this->filters['tanggal_akhir'])) {
            $query->whereBetween('tanggal', [$this->filters['tanggal_awal'], $this->filters['tanggal_akhir']]);
        }

        $data = $query->get();

        // Format data buat Excel, misal map ke array sederhana
        return $data->map(function($item){
            return [
                'Nama Siswa'   => $item->siswa->nama ?? '-',
                'Kelas'        => $item->kelas->nama ?? '-',
                'Tanggal'      => $item->tanggal,
                'Status'       => $item->status,
                'Keterangan'   => $item->keterangan ?? '-',
                'Semester'     => $item->semester,
                'Tahun Ajaran' => $item->tahun_ajaran,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Tanggal',
            'Status',
            'Keterangan',
            'Semester',
            'Tahun Ajaran',
        ];
    }
}
