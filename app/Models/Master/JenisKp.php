<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatGolongan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisKp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_kp';

    protected $fillable = ['kode_kp', 'nama'];

    public function riwayat_golongan()
    {
        return $this->hasMany(RiwayatGolongan::class, 'kode_kp', 'kode_kp');
    }


}
