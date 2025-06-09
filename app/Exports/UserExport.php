<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = User::query()->orderBy('name');
        if ($this->request->filled('search')) {
            $query->where('name', 'like', '%' . $this->request->search . '%')
                  ->orWhere('email', 'like', '%' . $this->request->search . '%');
        }
        if ($this->request->filled('role')) {
            $query->where('role', $this->request->role);
        }
        return $query;
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Role', 'Tanggal Terdaftar'];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            \Illuminate\Support\Str::title($user->role),
            $user->created_at->isoFormat('D MMMM Y, HH:mm'),
        ];
    }
}