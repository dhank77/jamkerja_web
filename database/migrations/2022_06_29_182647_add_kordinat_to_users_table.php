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
        Schema::table('users', function (Blueprint $table) {
            $table->string('kordinat')->nullable()->after('email');
            $table->string('latitude')->nullable()->after('kordinat');
            $table->string('longitude')->nullable()->after('latitude');
            $table->integer('jarak')->default(0)->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kordinat');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('jarak');
        });
    }
};
