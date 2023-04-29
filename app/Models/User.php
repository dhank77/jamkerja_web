<?php

namespace App\Models;

use App\Models\Master\StatusPegawai;
use App\Models\Master\Suku;
use App\Models\Payroll\DataPayroll;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\Pegawai\Keluarga;
use App\Models\Pegawai\RiwayatGolongan;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\Pegawai\RiwayatKursus;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\Pegawai\RiwayatPenghargaan;
use App\Models\Pegawai\RiwayatStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'images',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'nip';
    }

    public function riwayat_kgb()
    {
        return $this->hasMany(RiwayatKgb::class, 'nip', 'nip');
    }

    public function riwayat_golongan()
    {
        return $this->hasMany(RiwayatGolongan::class, 'nip', 'nip');
    }

    public function riwayat_jabatan()
    {
        return $this->hasMany(RiwayatJabatan::class, 'nip', 'nip');
    }

    public function riwayat_pendidikan()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'nip', 'nip')->orderByDesc('kode_pendidikan');
    }

    public function riwayat_kursus()
    {
        return $this->hasMany(RiwayatKursus::class, 'nip', 'nip');
    }

    public function riwayat_penghargaan()
    {
        return $this->hasMany(RiwayatPenghargaan::class, 'nip', 'nip');
    }

    public function keluarga()
    {
        return $this->hasMany(Keluarga::class, 'nip', 'nip');
    }

    public function riwayat_status()
    {
        return $this->hasMany(RiwayatStatus::class, 'nip', 'nip');
    }

    public function pengajuan_cuti()
    {
        return $this->hasMany(DataPengajuanCuti::class, 'nip', 'nip');
    }

    public function pengajuan_lembur()
    {
        return $this->hasMany(DataPengajuanLembur::class, 'nip', 'nip');
    }

    public function data_payroll()
    {
        return $this->hasMany(DataPayroll::class, 'nip', 'nip');
    }

    public function suku()
    {
        return $this->belongsTo(Suku::class, 'kode_suku', 'kode_suku');
    }

    public function status()
    {
        return $this->belongsTo(StatusPegawai::class, 'kode_status', 'kode_status');
    }

    public function jabatan_akhir()
    {
        return $this->riwayat_jabatan()->where('is_akhir', 1);
    }

    public function pendidikan_akhir()
    {
        return $this->riwayat_pendidikan()->where('is_akhir', 1);
    }

    public function golongan_akhir()
    {
        return $this->riwayat_golongan()->where('is_akhir', 1);
    }

    public function getImagesAttribute()
    {
        return $this->image ? asset("storage/$this->image") : asset("no-image.png");
    }

    public function scopeUltah($query)
    {
        return $query->whereRaw('extract(month from tanggal_lahir) = ?', [Carbon::today()->month])->whereRaw('extract(day from tanggal_lahir) = ?', [Carbon::today()->day])->orderBy('tanggal_lahir', 'asc');
    }
}
