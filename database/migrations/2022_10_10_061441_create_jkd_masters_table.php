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
        Schema::create('jkd_master', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('kode_jkd');
            $table->string('nama');
            $table->string('jam_datang');
            $table->string('jam_pulang');
            $table->double('istirahat')->default(0)->comment("menit");
            $table->tinyInteger('toleransi_datang')->default(0)->comment("menit");
            $table->tinyInteger('toleransi_pulang')->default(0)->comment("menit");
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
        Schema::dropIfExists('jkd_master');
    }
};
