<?php

namespace App\Models\Presensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiFree extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "presensi_free";
}
