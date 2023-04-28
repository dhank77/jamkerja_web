<?php

namespace App\Models\Pegawai;

use App\Models\Master\Golongan;
use App\Models\Master\StatusPegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_status';

    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(StatusPegawai::class, 'kode_status', 'kode_status');
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'kode_golongan', 'kode_golongan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
