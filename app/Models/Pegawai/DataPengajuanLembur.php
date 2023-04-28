<?php

namespace App\Models\Pegawai;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPengajuanLembur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "data_pengajuan_lembur";

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
