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
        Schema::create('riwayat_potongan_cuti', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->year('tahun');
            $table->tinyInteger('hari');
            $table->string('keterangan')->comment('potongan, penambahan');
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
        Schema::dropIfExists('riwayat_potongan_cuti');
    }
};
