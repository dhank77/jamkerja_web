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
        Schema::create('riwayat_pmk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('nip');
            $table->string('jenis_pmk');
            $table->string('instansi');
            $table->date('tanggal_awal')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->integer('masa_kerja_bulan')->nullable();
            $table->integer('masa_kerja_tahun')->nullable();
            $table->string('nomor_bkn')->nullable();
            $table->date('tanggal_bkn')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('riwayat_pmk');
    }
};
