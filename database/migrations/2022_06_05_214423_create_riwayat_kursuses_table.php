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
        Schema::create('riwayat_kursus', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('kode_kursus');
            $table->string('tempat')->nullable();
            $table->string('pelaksana')->nullable();
            $table->string('angkatan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->integer('jumlah_jp')->nullable();
            $table->string('no_sertifikat')->nullable();
            $table->string('tanggal_sertifikat')->nullable();
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
        Schema::dropIfExists('riwayat_kursus');
    }
};
