<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('konten');
            $table->string('kategori');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis
            $table->string('status')->default('Unpublish');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
};