<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tanggal',
        'status',
        'keterangan',
        'waktu',
        'tahun_ajaran',
        'mapel_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel() // <-- TAMBAHKAN RELASI INI
    {
        return $this->belongsTo(Mapel::class);
    }
}