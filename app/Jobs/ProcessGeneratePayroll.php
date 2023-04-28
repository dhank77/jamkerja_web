<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGeneratePayroll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $nip;
    public $no_hp;
    public $jabatan;
    public $kode_payroll;
    public $bulan;
    public $tahun;

    public function __construct($nip, $no_hp, $jabatan, $kode_payroll, $bulan, $tahun)
    {
        $this->nip = $nip;
        $this->no_hp = $no_hp;
        $this->jabatan = $jabatan;
        $this->kode_payroll = $kode_payroll;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    
    public function handle()
    {
        sleep(10);
        generate_payroll_nip($this->nip, $this->no_hp, $this->jabatan, $this->kode_payroll, $this->bulan, $this->tahun);
    }
}
