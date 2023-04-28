<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatPendidikan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jurusan';

    protected $fillable = ['kode_jurusan', 'kode_pendidikan', 'nama'];

    public function pendidikan()
    {
        return $this->hasOne(Pendidikan::class, 'kode_pendidikan', 'kode_pendidikan');
    }

    public function riwayat_pendidikan()
    {
        $this->belongsToMany(RiwayatPendidikan::class, 'kode_jurusan', 'kode_jurusan');
    }
}
