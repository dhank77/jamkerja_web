<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jabatan';

    protected $guarded = [];

    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'kode_skpd', 'kode_skpd');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'kode_bidang', 'kode_bidang');
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'kode_seksi', 'kode_seksi');
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'kode_eselon', 'kode_eselon');
    }

    public function atasan()
    {
        return $this->belongsTo(Jabatan::class, 'kode_atasan', 'kode_jabatan');
    }

    public function bawahan()
    {
        return $this->hasMany(Jabatan::class, 'kode_atasan', 'kode_jabatan');
    }

    public function riwayat_jabatan()
    {
        return $this->hasMany(Jabatan::class, 'kode_jabatan', 'kode_jabatan');
    }
}
