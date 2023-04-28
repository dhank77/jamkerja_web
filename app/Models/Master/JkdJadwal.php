<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JkdJadwal extends Model
{
    use HasFactory;

    protected $table = 'jkd_jadwal';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'nip', 'nip');
    }

    public function jkd_master()
    {
        return $this->hasOne(JkdMaster::class, 'kode_jkd', 'kode_jkd');
    }
}
