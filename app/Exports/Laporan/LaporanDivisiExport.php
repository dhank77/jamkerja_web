<?php

namespace App\Exports\Laporan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanDivisiExport implements FromView
{
    public $bulan;
    public $tahun;
    public $kode;
    public $pegawai;
    public function __construct($bulan, $tahun, $kode, $pegawai) {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->pegawai = $pegawai;
        $this->kode = $kode;
    }
    
    public function view(): View
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;
        $pegawai = $this->pegawai;
        $kode = $this->kode;
        return view('laporan.presensi.divisi-xls', compact('bulan', 'tahun', 'pegawai', 'kode'));
    }
}