<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_nip', 'nip');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_nip', 'nip');
    }
}
