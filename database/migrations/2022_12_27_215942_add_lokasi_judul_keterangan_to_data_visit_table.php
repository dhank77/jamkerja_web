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
        Schema::table('data_visit', function (Blueprint $table) {
            $table->string('judul')->after('tanggal')->nullable();
            $table->string('keterangan')->after('judul')->nullable();
            $table->string('lokasi')->after('kordinat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_visit', function (Blueprint $table) {
            $table->dropColumn('judul');
            $table->dropColumn('keterangan');
            $table->dropColumn('lokasi');
        });
    }
};
