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
        Schema::create('riwayat_kgb', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_tmt');
            $table->double('gaji_pokok');
            $table->integer('masa_kerja_tahun');
            $table->integer('masa_kerja_bulan');
            $table->string('file')->nullable();
            $table->tinyInteger('is_akhir')->default(0);
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
        Schema::dropIfExists('riwayat_kgb');
    }
};
