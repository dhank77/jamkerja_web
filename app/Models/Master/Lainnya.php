<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatLainnya;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lainnya extends Model
{
    use HasFactory;

    protected $table = "lainnya";

    protected $guarded = [];


    public function riwayat_lainnya()
    {
        return $this->hasMany(RiwayatLainnya::class, 'kode_lainnya', 'kode_lainnya');
    }
}
