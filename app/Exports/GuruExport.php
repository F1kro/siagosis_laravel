<?php

namespace App\Exports;

use App\Models\Guru;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuruExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Guru::query()->with('user')->orderBy('nama', 'asc');
        if ($this->request->filled('search')) {
            $query->where('nama', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nip', 'like', '%' . $this->request->search . '%');
        }
        return $query;
    }

    public function headings(): array
    {
        return ['NIP', 'Nama Guru', 'Email'];
    }

    public function map($guru): array
    {
        return [
            $guru->nip ?? 'N/A',
            $guru->nama,
            $guru->user->email ?? 'N/A',
        ];
    }
}