<?php

namespace App\Models\Payroll;

use App\Models\Master\Payroll\Pengurangan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarKurangPayroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "daftar_kurang_payroll";

    protected $guarded = [];

    public function kurang()
    {
        return $this->belongsTo(Pengurangan::class, 'kode_kurang', 'kode_kurang');
    }
}
