<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
    // public function up()
    // {
    //     Schema::create('absensi', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
    //         $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
    //         $table->date('tanggal');
    //         $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
    //         $table->text('keterangan')->nullable();
    //         $table->time('waktu')->nullable();
    //         $table->timestamps();
    //     });
    // }


return new class extends Migration {
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
            $table->text('keterangan')->nullable();

            // Tambahan untuk laporan per semester
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran'); // Contoh: 2024/2025

            $table->timestamps();

            $table->unique(['siswa_id', 'tanggal'], 'absensi_unique_siswa_tanggal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
};


//     public function down()
//     {
//         Schema::dropIfExists('absensi');
//     }
// };