<?php

namespace App\Models\Master;

use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\RiwayatCuti;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuti extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "cuti";

    protected $guarded = [];

    public function riwayat_cuti()
    {
        return $this->hasMany(RiwayatCuti::class, 'kode_cuti', 'kode_cuti');
    }

    public function pengajuan_cuti()
    {
        return $this->hasMany(DataPengajuanCuti::class, 'kode_cuti', 'kode_cuti');
    }
}
