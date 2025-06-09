<?php

namespace App\Exports;

use App\Models\Mapel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MapelExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Mapel::query()->orderBy('nama');
        if ($this->request->filled('search')) {
            $query->where('nama', 'like', '%' . $this->request->search . '%')
                  ->orWhere('kode', 'like', '%' . $this->request->search . '%');
        }
        return $query;
    }

    public function headings(): array
    {
        return ['Kode Mapel', 'Nama Mata Pelajaran', 'Tingkat Kelas', 'KKM', 'Jumlah Jam'];
    }

    public function map($mapel): array
    {
        return [
            $mapel->kode,
            $mapel->nama,
            $mapel->kelas,
            $mapel->kkm,
            $mapel->jumlah_jam,
        ];
    }
}