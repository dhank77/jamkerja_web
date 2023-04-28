<?php

namespace App\Models\Pegawai;

use App\Models\Master\Kursus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatKursus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_kursus";

    protected $guarded = [];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kode_kursus', 'kode_kursus');
    }

}
