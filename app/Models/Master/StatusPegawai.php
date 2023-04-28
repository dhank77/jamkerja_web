<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusPegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'status_pegawai';

    protected $fillable = ['kode_status', 'nama'];

    public function riwayat_status()
    {
        return $this->hasMany(RiwayatStatus::class, 'kode_status', 'kode_status');
    }

}
