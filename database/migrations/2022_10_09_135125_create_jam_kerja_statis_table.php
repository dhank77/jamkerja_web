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
        Schema::create('jam_kerja_statis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('kode_jam_kerja');
            $table->string('nama');
            $table->tinyInteger('hari');
            $table->string('jam_datang')->nullable();
            $table->string('jam_pulang')->nullable();
            $table->double('istirahat')->comment("menit")->default(0)->nullable();
            $table->tinyInteger('toleransi_datang')->comment("menit")->default(0)->nullable();
            $table->tinyInteger('toleransi_pulang')->comment("menit")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jam_kerja_statis');
    }
};
