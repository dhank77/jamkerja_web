<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatJabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';

    protected $guarded = [];

    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'kode_skpd', 'kode_skpd');
    }

    public function seksi()
    {
        return $this->hasMany(Seksi::class, 'kode_bidang', 'kode_bidang');
    }

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'kode_bidang', 'kode_bidang');
    }

    public function riwayat_jabatan()
    {
        return $this->hasMany(RiwayatJabatan::class, 'kode_bidang', 'kode_bidang');
    }
}
