<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        Berita::create([
            'judul' => 'Pengumuman Ujian Akhir Semester',
            'konten' => 'Ujian Akhir Semester akan dilaksanakan pada tanggal 10-15 Juni 2024. Siswa diharapkan mempersiapkan diri dengan baik.',
            'kategori' => 'Pengumuman',
            'user_id' => 1, // Admin
            'status' => 'Dipublikasikan',
        ]);

        Berita::create([
            'judul' => 'Jadwal Kegiatan Ekstrakurikuler',
            'konten' => 'Kegiatan ekstrakurikuler akan dimulai pada minggu kedua bulan Juli 2024. Siswa dapat mendaftar melalui wali kelas masing-masing.',
            'kategori' => 'Kegiatan',
            'user_id' => 1, // Admin
            'status' => 'Dipublikasikan',
        ]);

        Berita::create([
            'judul' => 'Prestasi Siswa dalam Olimpiade Matematika',
            'konten' => 'Selamat kepada Andi Wijaya yang telah meraih juara 1 dalam Olimpiade Matematika tingkat kota.',
            'kategori' => 'Prestasi',
            'user_id' => 1, // Admin
            'status' => 'Dipublikasikan',
        ]);
    }
}