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
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('status');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nip_keluarga')->nullable();
            $table->string('status_kehidupan')->default('hidup');
            $table->string('status_pernikahan')->nullable();
            $table->string('id_ibu')->nullable();
            $table->string('status_anak')->nullable();
            $table->tinyInteger('anak_ke')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('nomor_bpjs')->nullable();
            $table->string('file_bpjs')->nullable();
            $table->string('nomor_akta_kelahiran')->nullable();
            $table->string('file_akta_kelahiran')->nullable();
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
        Schema::dropIfExists('keluarga');
    }
};
