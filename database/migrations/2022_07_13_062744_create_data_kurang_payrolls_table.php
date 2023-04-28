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
        Schema::create('daftar_kurang_payroll', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kurang');
            $table->tinyInteger('is_periode');
            $table->tinyInteger('bulan')->nullable();
            $table->year('tahun')->nullable();
            $table->string('keterangan')->comment('0 Semua Pegawai, 1 Pegawai Terpilih, 2 Jabatan Terpilih, 3 Level Jabatan, 4 Divisi Kerja');
            $table->string('kode_keterangan')->nullable();
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
        Schema::dropIfExists('daftar_kurang_payroll');
    }
};
