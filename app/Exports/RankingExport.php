<?php

namespace App\Exports;

use App\Models\Ranking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RankingExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        if (!$this->request->filled(['kelas_id', 'semester', 'tahun_ajaran'])) {
            return Ranking::query()->whereRaw('1=0');
        }

        return Ranking::query()->with('siswa')
            ->where('kelas_id', $this->request->kelas_id)
            ->where('semester', $this->request->semester)
            ->where('tahun_ajaran', $this->request->tahun_ajaran)
            ->orderBy('ranking_kelas', 'asc');
    }

    public function headings(): array
    {
        return [
            'Peringkat',
            'NISN',
            'Nama Siswa',
            'Total Nilai',
            'Nilai Rata-rata',
        ];
    }

    public function map($ranking): array
    {
        return [
            $ranking->ranking_kelas,
            $ranking->siswa->nisn ?? 'N/A',
            $ranking->siswa->nama ?? 'N/A',
            $ranking->total_nilai,
            $ranking->rata_rata_nilai,
        ];
    }
}