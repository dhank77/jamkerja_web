<?php

namespace App\Models\Pegawai;

use App\Models\Master\Reimbursement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPengajuanReimbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "data_pengajuan_reimbursement";

    protected $guarded = [];

    public function reimbursement()
    {
        return $this->belongsTo(Reimbursement::class, 'kode_reimbursement', 'kode_reimbursement');
    }
}
