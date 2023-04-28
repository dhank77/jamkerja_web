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
        Schema::create('payroll_kurang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_payroll');
            $table->string('nip');
            $table->string('kode_kurang')->nullable();
            $table->string('keterangan')->nullable();
            $table->double('nilai');
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
        Schema::dropIfExists('payroll_kurang');
    }
};
