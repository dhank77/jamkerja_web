<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatKursus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kursus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "kursus";

    protected $guarded = [];

    public function riwayat_kursus()
    {
        return $this->hasMany(RiwayatKursus::class, 'kode_kursus', 'kode_kursus');
    }
}
