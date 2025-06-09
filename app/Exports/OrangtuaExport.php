<?php

namespace App\Exports;

use App\Models\Orangtua;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrangtuaExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Orangtua::query()->with('siswa.kelas')->orderBy('nama', 'asc');
        if ($this->request->filled('search')) {
            $query->where('nama', 'like', '%' . $this->request->search . '%')
                  ->orWhereHas('siswa', function($q) {
                      $q->where('nama', 'like', '%' . $this->request->search . '%');
                  });
        }
        return $query;
    }

    public function headings(): array
    {
        return [
            'Nama Orang Tua',
            'Nama Siswa',
            'Kelas Siswa',
            'Telepon',
            'Pekerjaan'
        ];
    }

    public function map($orangtua): array
    {
        return [
            $orangtua->nama,
            $orangtua->siswa->nama ?? 'N/A',
            $orangtua->siswa->kelas->nama_kelas ?? 'N/A',
            $orangtua->telepon,
            $orangtua->pekerjaan,
        ];
    }
}