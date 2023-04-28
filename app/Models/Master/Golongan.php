<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatGolongan;
use App\Models\Pegawai\RiwayatStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Golongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'golongan';

    protected $fillable = ['kode_golongan', 'nama', 'nama_abjad', 'pangkat'];

    public function riwayat_status()
    {
        return $this->hasMany(RiwayatStatus::class, 'kode_golongan', 'kode_golongan');
    }

    public function riwayat_golongan()
    {
        return $this->hasMany(RiwayatGolongan::class, 'kode_golongan', 'kode_golongan');
    }

}
