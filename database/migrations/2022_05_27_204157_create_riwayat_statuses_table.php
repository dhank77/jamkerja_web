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
        Schema::create('riwayat_status', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('nip');
            $table->string('kode_status');
            $table->string('kode_golongan');
            $table->string('no_sk');
            $table->date('tanggal_sk');
            $table->date('tanggal_tmt');
            $table->tinyInteger('is_akhir')->default(0);
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
        Schema::dropIfExists('riwayat_status');
    }
};
