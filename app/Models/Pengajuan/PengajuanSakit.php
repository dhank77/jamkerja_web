<?php

namespace App\Models\Pengajuan;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSakit extends Model
{
    use HasFactory;

    protected $table = "data_pengajuan_sakit";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
