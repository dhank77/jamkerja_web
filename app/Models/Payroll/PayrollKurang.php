<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollKurang extends Model
{
    use HasFactory;

    protected $table = "payroll_kurang";

    protected $guarded = [];
}
