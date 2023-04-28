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
        Schema::create('data_presensi', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('kode_tingkat')->nullable();
            $table->string('kode_shift')->nullable();
            $table->timestamp('tanggal_datang')->nullable();
            $table->string('kordinat_datang')->nullable();
            $table->timestamp('tanggal_istirahat')->nullable();
            $table->string('kordinat_istirahat')->nullable();
            $table->timestamp('tanggal_pulang')->nullable();
            $table->string('kordinat_pulang')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_presensi');
    }
};
