<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneratePayroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "generate_payroll";

    protected $guarded = [];
}
