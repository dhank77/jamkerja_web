<?php

namespace App\Models\Pegawai;

use App\Models\Master\Golongan;
use App\Models\Master\JenisKp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatGolongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_golongan';

    protected $guarded = [];


    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'kode_golongan', 'kode_golongan');
    }

    public function jeniskp()
    {
        return $this->belongsTo(JenisKp::class, 'kode_kp', 'kode_kp');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

}
