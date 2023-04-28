<?php

namespace App\Models\Payroll;

use App\Models\Master\Payroll\Tambahan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarTambahPayroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "daftar_tambah_payroll";

    protected $guarded = [];

    public function tambah()
    {
        return $this->belongsTo(Tambahan::class, 'kode_tambah', 'kode_tambah');
    }
}
