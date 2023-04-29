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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan')->comment('uuid')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->text('alamat')->nullable();
            $table->text('kontak')->nullable();
            $table->string('logo')->nullable();
            $table->string('direktur')->nullable();
            $table->string('nomor')->nullable();
            $table->string('status')->default('basic')->comment('basic : absensi saja, pro: lengkap');
            $table->integer('jumlah_pegawai')->default(0);
            $table->date('expired_at');
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
        Schema::dropIfExists('perusahaan');
    }
};
