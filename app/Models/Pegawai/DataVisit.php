<?php

namespace App\Models\Pegawai;

use App\Models\Master\Visit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataVisit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_visit';

    protected $guarded = [];

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'kode_visit', 'kode_visit');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
