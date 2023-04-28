<?php

namespace App\Models\Pegawai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPresensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_presensi';

    protected $guarded = [];
}
