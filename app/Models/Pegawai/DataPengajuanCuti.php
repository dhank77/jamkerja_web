<?php

namespace App\Models\Pegawai;

use App\Models\Master\Cuti;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPengajuanCuti extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "data_pengajuan_cuti";

    protected $guarded = [];

    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'kode_cuti', 'kode_cuti');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
