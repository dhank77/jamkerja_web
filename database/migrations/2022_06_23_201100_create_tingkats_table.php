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
        Schema::create('tingkat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('kode_skpd');
            $table->string('parent_id')->nullable();
            $table->string('kode_tingkat')->unique();
            $table->string('jenis_jabatan');
            $table->string('nama');
            $table->string('kode_eselon');
            $table->string('kordinat')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('jarak')->default(0);
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
        Schema::dropIfExists('tingkat');
    }
};
