<?php

namespace App\Models\Master\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tunjangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "ms_tunjangan";

    protected $guarded = [];
}
