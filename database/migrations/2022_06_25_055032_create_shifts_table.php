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
        Schema::create('shift', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('kode_shift');
            $table->string('nama');
            $table->string('jam_buka_datang')->nullable();
            $table->string('jam_tepat_datang')->nullable();
            $table->string('jam_tutup_datang')->nullable();
            $table->integer('toleransi_datang')->nullable()->comment('dalam menit');
            $table->string('jam_buka_istirahat')->nullable();
            $table->string('jam_tepat_istirahat')->nullable();
            $table->string('jam_tutup_istirahat')->nullable();
            $table->integer('toleransi_istirahat')->nullable()->comment('dalam menit');
            $table->string('jam_buka_pulang')->nullable();
            $table->string('jam_tepat_pulang')->nullable();
            $table->string('jam_tutup_pulang')->nullable();
            $table->integer('toleransi_pulang')->nullable()->comment('dalam menit');
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
        Schema::dropIfExists('shift');
    }
};
