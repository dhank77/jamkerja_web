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
        Schema::create('lokasi_detail', function (Blueprint $table) {
            $table->id();
            $table->string('kode_lokasi');
            $table->string('keterangan_tipe')->default(0)->comment("0 memilih pegawai, 1 berdasarkan atasan dan bawahannya, 2 berdasarkan jabatan itu saja");
            $table->string('keterangan_id');
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
        Schema::dropIfExists('lokasi_detail');
    }
};
