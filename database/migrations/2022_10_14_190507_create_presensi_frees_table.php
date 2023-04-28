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
        Schema::create('presensi_free', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->date('tanggal');
            $table->string('rule_datang')->nullable();
            $table->string('jam_datang')->nullable();
            $table->string('kordinat_datang')->nullable();
            $table->string('image_datang')->nullable();
            $table->string('rule_pulang')->nullable();
            $table->string('jam_pulang')->nullable();
            $table->string('kordinat_pulang')->nullable();
            $table->string('image_pulang')->nullable();
            $table->double('rule_istirahat')->nullable()->default(0)->comment("menit");
            $table->string('jam_istirahat_mulai')->nullable();
            $table->string('jam_istirahat_selesai')->nullable();
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
        Schema::dropIfExists('presensi_free');
    }
};
