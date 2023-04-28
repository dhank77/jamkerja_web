<?php

namespace App\Models\Master;

use App\Models\Pegawai\DataPengajuanReimbursement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reimbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "reimbursement";

    protected $guarded = [];

    public function pengajuan_reimbursement()
    {
        return $this->hasMany(DataPengajuanReimbursement::class, 'kode_reimbursement', 'kode_reimbursement');
    }
}
