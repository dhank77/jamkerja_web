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
        Schema::table('jkd_master', function (Blueprint $table) {
            $table->string('color')->after('toleransi_pulang')->default("#FFC300");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jkd_master', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
