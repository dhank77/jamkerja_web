<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JksPegawai extends Model
{
    use HasFactory;

    protected $table = 'jks_pegawai';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
