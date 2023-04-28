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
        Schema::table('data_pengajuan_ijin', function (Blueprint $table) {
            $table->unsignedDouble("hari")->after("tanggal_selesai")->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_pengajuan_ijin', function (Blueprint $table) {
            $table->dropColumn("hari");
        });
    }
};
