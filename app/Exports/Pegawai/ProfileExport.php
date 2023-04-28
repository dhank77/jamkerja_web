<?php

namespace App\Exports\Pegawai;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProfileExport implements FromView
{
    public $pegawai;
    public function __construct($pegawai) {
        $this->pegawai = $pegawai;
    }
    
    public function view(): View
    {
        $pegawai = $this->pegawai;
        return view("pegawai.profile_xls", compact('pegawai'));;
    }
}