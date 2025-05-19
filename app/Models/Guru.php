<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'telepon',
        'jenis_kelamin',
        'tanggal_lahir',
        'pendidikan_terakhir',
        'alamat',
        'foto',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel')
            ->withPivot('kelas_id', 'tahun_ajaran')
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
}