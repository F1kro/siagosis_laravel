<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelas')->unique();
            $table->string('nama_kelas');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade'); // Wali kelas
            $table->string('tahun_ajaran');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas');
    }
};