<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatPendidikan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendidikan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pendidikan';

    protected $fillable = ['kode_pendidikan', 'nama'];

    public function jurusan()
    {
        $this->belongsToMany(Jurusan::class, 'kode_pendidikan', 'kode_pendidikan');
    }

    public function riwayat_pendidikan()
    {
        $this->belongsToMany(RiwayatPendidikan::class, 'kode_pendidikan', 'kode_pendidikan');
    }
}
