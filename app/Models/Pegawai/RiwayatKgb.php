<?php

namespace App\Models\Pegawai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatKgb extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_kgb";

    protected $guarded = [];
}
