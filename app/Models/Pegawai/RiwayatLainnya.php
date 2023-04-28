<?php

namespace App\Models\Pegawai;

use App\Models\Master\Lainnya;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatLainnya extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_lainnya";

    protected $guarded = [];

    public function lainnya()
    {
        return $this->belongsTo(Lainnya::class, 'kode_lainnya', 'kode_lainnya');
    }
}
