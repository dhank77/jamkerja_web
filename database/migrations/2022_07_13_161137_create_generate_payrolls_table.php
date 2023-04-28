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
        Schema::create('generate_payroll', function (Blueprint $table) {
            $table->id();
            $table->string('kode_payroll');
            $table->string('kode_skpd')->nullable()->comment("null berarti semua dinas");
            $table->tinyInteger('bulan');
            $table->year('tahun');
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
        Schema::dropIfExists('generate_payroll');
    }
};
