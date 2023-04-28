<?php

namespace App\Models\Pegawai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatLhkpn extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_lhkpn";

    protected $guarded = [];
}
