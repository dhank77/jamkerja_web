<?php

namespace App\Models\Pengajuan;

use App\Models\Master\Izin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    use HasFactory;

    protected $table = "data_pengajuan_izin";

    protected $guarded = [];

    public function izin()
    {
        return $this->belongsTo(Izin::class, 'kode_izin', 'kode_izin');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
