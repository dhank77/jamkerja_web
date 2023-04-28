<?php

namespace App\Models\Master;

use App\Models\Pengajuan\PengajuanIzin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = "izin";

    protected $guarded = [];

    public function pengajuan_izin()
    {
        return $this->hasMany(PengajuanIzin::class, 'kode_izin', 'kode_izin');
    }
}
