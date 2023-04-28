<?php

namespace App\Models\Master;

use App\Models\Pengajuan\PengajuanIjin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ijin extends Model
{
    use HasFactory;

    protected $table = "ijin";

    protected $guarded = [];

    public function pengajuan_ijin()
    {
        return $this->hasMany(PengajuanIjin::class, 'kode_ijin', 'kode_ijin');
    }
}
