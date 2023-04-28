<?php

namespace App\Models\Pegawai;

use App\Models\Master\Cuti;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatCuti extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_cuti";

    protected $guarded = [];

    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'kode_cuti', 'kode_cuti');
    }
}
