<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->enum('jenis_nilai', ['Tugas', 'Ulangan', 'UTS', 'UAS']);
            $table->float('nilai');

            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran'); // contoh: 2024/2025

            $table->timestamps();

            // Mencegah input dobel dari guru yang sama untuk jenis nilai sama
            $table->unique(['siswa_id', 'mapel_id', 'guru_id', 'jenis_nilai', 'semester', 'tahun_ajaran'], 'unique_nilai_entry');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai');
    }
};