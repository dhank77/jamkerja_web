<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_presensi', function (Blueprint $table) {
            $table->string('foto_datang')->nullable()->after('kordinat_datang');
            $table->string('foto_istirahat')->nullable()->after('kordinat_istirahat');
            $table->string('foto_pulang')->nullable()->after('kordinat_pulang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_presensi', function (Blueprint $table) {
            $table->string('foto_datang');
            $table->string('foto_istirahat');
            $table->string('foto_pulang');
        });
    }
};
