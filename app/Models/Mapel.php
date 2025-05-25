<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $fillable = [
        'kode',
        'nama',
        'kelas',
        'kkm',
        'jumlah_jam',
    ];

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel')
            // ->withPivot('kelas_id', 'tahun_ajaran')
            ->withTimestamps();
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function todoList()
    {
        return $this->hasMany(TodoList::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mapel', 'mapel_id', 'kelas_id')
            ->withTimestamps();
    }

}
