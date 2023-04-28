<?php

namespace App\Models\Pegawai;

use App\Models\Master\Shift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatShift extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_shift";

    protected $guarded = [];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'kode_shift', 'kode_shift');
    }
}
