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
        Schema::create('riwayat_lhkasn', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('nip');
            $table->date('tanggal_pelaporan');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('riwayat_lhkasn');
    }
};
