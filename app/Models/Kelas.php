<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'guru_id',
        'tahun_ajaran',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class);
    }

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'kelas_mapel')
            ->withPivot('tahun_ajaran')
            ->withTimestamps();
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_id'); 
    }

}
