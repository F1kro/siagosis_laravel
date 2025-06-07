<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $table = 'rankings';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran',
        'semester',
        'total_nilai',
        'rata_rata_nilai',
        'ranking_kelas',
        'ranking_angkatan',
    ];

    /**
     * Mendefinisikan bahwa satu data ranking dimiliki oleh satu siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Mendefinisikan bahwa satu data ranking merujuk pada satu kelas.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}