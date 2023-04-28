<?php

namespace App\Models\Pengajuan;

use App\Models\Master\Ijin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanIjin extends Model
{
    use HasFactory;
    protected $table = "data_pengajuan_ijin";

    protected $guarded = [];

    public function ijin()
    {
        return $this->belongsTo(Ijin::class, 'kode_ijin', 'kode_ijin');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
