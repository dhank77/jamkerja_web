<?php

namespace App\Models\Pegawai;

use App\Models\Master\Penghargaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPenghargaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_penghargaan";

    protected $guarded = [];

    public function penghargaan()
    {
        return $this->belongsTo(Penghargaan::class, 'kode_penghargaan', 'kode_penghargaan');
    }
}
