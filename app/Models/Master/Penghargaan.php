<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatPenghargaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penghargaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "penghargaan";

    protected $guarded = [];

    public function riwayat_penghargaan()
    {
        return $this->hasMany(RiwayatPenghargaan::class, 'kode_penghargaan', 'kode_penghargaan');
    }
}
