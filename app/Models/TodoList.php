<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $table = 'todo_list';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'judul',
        'deskripsi',
        'deadline',
        'selesai',
      ];

    /**
     * Casts disesuaikan untuk 'deadline' dan 'selesai'.
     */
    protected $casts = [
        'deadline' => 'date',
        'selesai' => 'boolean', 
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}