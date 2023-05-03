<?php

namespace App\Models\Master\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "ms_lembur";

    public function getRouteKeyName()
    {
        return 'kode_lembur';
    }
}
