<?php

namespace App\Exports;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Jadwal::query()->with('kelas', 'mapel', 'guru');
        if ($this->request->filled('kelas_id')) {
            $query->where('kelas_id', $this->request->kelas_id);
        }
        if ($this->request->filled('hari')) {
            $query->where('hari', $this->request->hari);
        }
        $hariOrder = "FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";
        return $query->orderByRaw($hariOrder)->orderBy('jam_mulai', 'asc');
    }

    public function headings(): array
    {
        return ['Hari', 'Jam Mulai', 'Jam Selesai', 'Mata Pelajaran', 'Guru', 'Ruangan'];
    }

    public function map($jadwal): array
    {
        return [
            $jadwal->hari,
            \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i'),
            \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i'),
            $jadwal->mapel->nama ?? 'N/A',
            $jadwal->guru->nama ?? 'N/A',
            $jadwal->ruangan,
        ];
    }
}