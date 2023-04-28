<?php

namespace App\Models\Master;

use App\Models\Pagawai\DataVisit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = "visit_lokasi";

    protected $guarded = [];

    public function data_visit()
    {
        return $this->hasMany(DataVisit::class, 'kode_visit', 'kode_visit');
    }
}
