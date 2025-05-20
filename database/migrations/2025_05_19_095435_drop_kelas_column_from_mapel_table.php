<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropKelasColumnFromMapelTable extends Migration
{
    public function up()
    {
        Schema::table('mapel', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });
    }

    public function down()
    {
        Schema::table('mapel', function (Blueprint $table) {
            $table->string('kelas')->nullable();
        });
    }
}
