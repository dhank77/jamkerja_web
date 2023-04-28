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
            $table->string('image')->after('alamat_ktp')->nullable();
            $table->string('no_hp')->after('email')->nullable();
            $table->string('nip')->after('id')->nullable();
            $table->string('nik')->after('nip')->nullable();
            $table->string('gelar_depan')->after('name')->nullable();
            $table->string('gelar_belakang')->after('gelar_depan')->nullable();
            $table->string('tempat_lahir')->after('gelar_belakang')->nullable();
            $table->date('tanggal_lahir')->after('tempat_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->after('tanggal_lahir')->nullable();
            $table->string('kode_agama')->after('jenis_kelamin')->nullable();
            $table->foreignId('kode_status')->after('kode_agama')->nullable();
            $table->string('kode_kawin')->after('kode_status')->nullable();
            $table->foreignId('kode_suku')->after('kode_kawin')->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->after('kode_suku')->nullable();
            $table->text('alamat')->after('golongan_darah')->nullable();
            $table->text('alamat_ktp')->after('alamat')->nullable();
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
            $table->dropColumn('id_pns');
            $table->dropColumn('nip');
            $table->dropColumn('nik');
            $table->dropColumn('gelar_depan');
            $table->dropColumn('gelar_belakang');
            $table->dropColumn('tempat_lahir');
            $table->dropColumn('tanggal_lahir');
            $table->dropColumn('jenis_kelamin');
            $table->dropColumn('kode_agama');
            $table->dropColumn('kode_status');
            $table->dropColumn('kode_kawin');
            $table->dropColumn('kode_suku');
            $table->dropColumn('golongan_darah');
            $table->dropColumn('alamat');
            $table->dropColumn('alamat_ktp');
        });
    }
};
