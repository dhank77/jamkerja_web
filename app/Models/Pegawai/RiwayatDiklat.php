<?php

namespace App\Models\Pegawai;

use App\Models\Master\DiklatStruktural;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatDiklat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_diklat";
    protected $guarded = [];

    public function diklat()
    {
        return $this->belongsTo(DiklatStruktural::class, 'kode_diklat_struktural', 'kode_diklat_struktural');
    }
}
