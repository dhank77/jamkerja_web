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
        Schema::create('data_payroll', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perusahaan');
            $table->string('kode_payroll');
            $table->tinyInteger('bulan');
            $table->year('tahun');
            $table->string('nip');
            $table->string('kode_tingkat');
            $table->string('jabatan')->nullable();
            $table->string('divisi')->nullable();
            $table->double('gaji_pokok');
            $table->double('tunjangan')->nullable();
            $table->double('total')->nullable();
            $table->double('total_penambahan')->nullable();
            $table->double('total_potongan')->nullable();
            $table->tinyInteger('is_aktif')->default(0);
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
        Schema::dropIfExists('data_payroll');
    }
};
