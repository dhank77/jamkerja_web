<?php

namespace App\Exports\Laporan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPegawaiExport implements FromView
{
    public $bulan;
    public $tahun;
    public $xl;
    public $pegawai;
    public function __construct($bulan, $tahun, $xl, $pegawai) {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->pegawai = $pegawai;
        $this->xl = $xl;
    }
    
    public function view(): View
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;
        $pegawai = $this->pegawai;
        $xl = $this->xl;
        return view('laporan.presensi.pegawai-xls', compact('bulan', 'tahun', 'pegawai', 'xl'));
    }
}
