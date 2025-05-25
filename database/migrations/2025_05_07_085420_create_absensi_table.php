<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('mapel_id')->nullable()->constrained('mapel')->onDelete('set null');

            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
            $table->text('keterangan')->nullable();
            $table->time('waktu')->nullable();

            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran');

            $table->timestamps();

            $table->unique(['siswa_id', 'tanggal', 'mapel_id'], 'absensi_unique_siswa_tanggal_mapel');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
};