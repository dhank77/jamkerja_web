<?php

namespace App\Models\Pegawai;

use App\Models\Master\Jurusan;
use App\Models\Master\Pendidikan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPendidikan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_pendidikan';

    protected $guarded = [];

    public function pendidikan()
    {
        return $this->hasOne(Pendidikan::class, 'kode_pendidikan', 'kode_pendidikan');
    }

    public function jurusan()
    {
        return $this->hasOne(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }
}
