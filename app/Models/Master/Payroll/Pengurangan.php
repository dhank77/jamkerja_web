<?php

namespace App\Models\Master\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurangan extends Model
{
    use HasFactory;

    protected $table = "ms_pengurangan";

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'kode_kurang';
    }
}
