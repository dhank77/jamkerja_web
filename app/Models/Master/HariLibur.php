<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HariLibur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hari_libur';

    protected $guarded = [];
}
