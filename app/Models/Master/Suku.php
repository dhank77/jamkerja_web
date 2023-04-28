<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suku';

    protected $fillable = ['kode_suku', 'nama'];

    public function users()
    {
        return $this->hasMany(Users::class, 'kode_suku', 'kode_suku');
    }

}
