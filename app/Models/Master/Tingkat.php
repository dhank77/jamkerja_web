<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    use HasFactory;

    protected $table = 'tingkat';

    protected $guarded = [];

    protected $appends = [
        'parents',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'kode_tingkat');
    }

    public function children()
    {
        return $this->hasMany(self::class,  'parent_id', 'kode_tingkat');
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'kode_eselon', 'kode_eselon');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    
}
