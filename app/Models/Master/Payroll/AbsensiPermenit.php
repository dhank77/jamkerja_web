<?php

namespace App\Models\Master\Payroll;

use App\Models\Master\Eselon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPermenit extends Model
{
    use HasFactory;

    protected $table = 'ms_absensi_permenit';

    protected $guarded = [];

    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'kode_eselon', 'kode_eselon');
    }
}
