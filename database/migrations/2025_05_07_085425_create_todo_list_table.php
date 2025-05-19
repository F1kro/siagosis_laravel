<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('todo_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('deadline');
            $table->foreignId('mapel_id')->nullable()->constrained('mapel')->onDelete('set null');
            $table->boolean('selesai')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('todo_list');
    }
};