<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('kelas');
            $table->integer('kkm');
            $table->integer('jumlah_jam');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapel');
    }
};