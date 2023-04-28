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
        Schema::create('riwayat_shift', function (Blueprint $table) {
            $table->id();
            $table->string('kode_shift');
            $table->string('nip');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->tinyInteger('is_akhir')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('komentar')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('riwayat_shift');
    }
};
