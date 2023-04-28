<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatDiklat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiklatStruktural extends Model
{
    use HasFactory;

    protected $table = "diklat_struktural";

    protected $guarded = [];

    public function riwayat_diklat()
    {
        return $this->hasMany(RiwayatDiklat::class, 'kode_diklat_struktural', 'kode_diklat_struktural');
    }
}
