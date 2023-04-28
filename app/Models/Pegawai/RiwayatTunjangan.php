<?php

namespace App\Models\Pegawai;

use App\Models\Master\Payroll\Tunjangan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatTunjangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_tunjangan';

    protected $guarded = [];

    public function tunjangan()
    {
        return $this->belongsTo(Tunjangan::class, 'kode_tunjangan', 'kode_tunjangan');
    }
}
