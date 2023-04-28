<?php

namespace App\Exports\Laporan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengajuanExport implements FromView
{
    public $bulan;
    public $tahun;
    public $data;
    public $jenis_laporan;
    public $view;
    public $tanggal;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $xls;

    public function __construct($data, $jenis_laporan, $tanggal, $bulan, $tahun, $tanggal_mulai, $tanggal_selesai, $xls, $view) {
        $this->data = $data;
        $this->jenis_laporan = $jenis_laporan;
        $this->tanggal = $tanggal;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
        $this->xls = $xls;
        $this->view = $view;
    }
    
    public function view(): View
    {
        $data = $this->data;
        $jenis_laporan = $this->jenis_laporan;
        $tanggal = $this->tanggal;
        $bulan = $this->bulan;
        $tahun = $this->tahun;
        $tanggal_mulai = $this->tanggal_mulai;
        $tanggal_selesai = $this->tanggal_selesai;
        $xls = $this->xls;

        return view($this->view, compact('data', 'jenis_laporan', 'tanggal', 'bulan', 'tahun', 'tanggal_mulai', 'tanggal_selesai', 'xls'));
    }
}