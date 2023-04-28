<?php

namespace App\Models\Master\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Potongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "ms_potongan";

    protected $guarded = [];
}
