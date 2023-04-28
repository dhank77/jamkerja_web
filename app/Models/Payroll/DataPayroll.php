<?php

namespace App\Models\Payroll;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPayroll extends Model
{
    use HasFactory;

    protected $table = "data_payroll";

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

}
