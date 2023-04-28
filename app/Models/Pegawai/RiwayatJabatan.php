<?php

namespace App\Models\Pegawai;

use App\Models\Master\Bidang;
use App\Models\Master\Jabatan;
use App\Models\Master\Seksi;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_jabatan';
    // protected $with = ["skpd"];

    protected $guarded = [];

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'kode_tingkat', 'kode_tingkat');
    }

    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'kode_skpd', 'kode_skpd');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'kode_bidang', 'kode_bidang');
    }
    
    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'kode_seksi', 'kode_seksi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }


}
