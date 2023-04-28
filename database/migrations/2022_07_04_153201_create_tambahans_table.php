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
        Schema::create('ms_tambahan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tambah');
            $table->string('nama');
            $table->tinyInteger('satuan')->comment('0: Rupiah, 1: Persen')->default(0);
            $table->double('nilai');
            $table->string('kode_persen')->nullable()->comment("1 : gaji pokok, selainnya dari kode tambah");
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
        Schema::dropIfExists('ms_tambahan');
    }
};
