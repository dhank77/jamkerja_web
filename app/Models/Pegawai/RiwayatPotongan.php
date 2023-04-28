<?php

namespace App\Models\Pegawai;

use App\Models\Master\Payroll\Pengurangan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPotongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_potongan';

    protected $guarded = [];

    public function potongan()
    {
        return $this->belongsTo(Pengurangan::class, 'kode_kurang', 'kode_kurang');
    }
}
