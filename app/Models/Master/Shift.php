<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatShift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shift';

    protected $guarded = [];

    public function riwayat_shift()
    {
        return $this->hasMany(RiwayatShift::class, 'kode_shift', 'kode_shift');
    }
}
