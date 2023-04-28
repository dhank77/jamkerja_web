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
        Schema::table('tingkat', function (Blueprint $table) {
            $table->double('gaji_pokok')->nullable()->after('kode_eselon');
            $table->double('tunjangan')->nullable()->after('gaji_pokok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tingkat', function (Blueprint $table) {
            $table->dropColumn('gaji_pokok');
            $table->dropColumn('tunjangan');
        });
    }
};
