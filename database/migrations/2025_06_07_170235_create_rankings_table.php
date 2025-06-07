<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->decimal('total_nilai', 8, 2);
            $table->decimal('rata_rata_nilai', 5, 2);
            $table->unsignedInteger('ranking_kelas');
            $table->unsignedInteger('ranking_angkatan')->nullable(); // Peringkat se-angkatan (opsional tapi bagus)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};