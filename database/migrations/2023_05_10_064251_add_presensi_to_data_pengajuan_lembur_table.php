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
        Schema::table('data_pengajuan_lembur', function (Blueprint $table) {
            $table->timestamp('jam_masuk')->after('jam_selesai')->nullable();
            $table->string('kordinat_masuk')->after('jam_masuk')->nullable();
            $table->timestamp('jam_keluar')->after('kordinat_masuk')->nullable();
            $table->string('kordinat_keluar')->after('jam_keluar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_pengajuan_lembur', function (Blueprint $table) {
            $table->dropColumn('jam_masuk');
            $table->dropColumn('kordinat_masuk');
            $table->dropColumn('jam_keluar');
            $table->dropColumn('kordinat_keluar');
        });
    }
};
