<?php

namespace App\Imports\Master;

use App\Models\Master\JkdJadwal;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class JadwalImport implements ToModel, WithHeadingRow, WithValidation
{
    public $bulan;
    public $tahun;
    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function model(array $row)
    {
        $number = cal_days_in_month(CAL_GREGORIAN, $this->bulan, $this->tahun);

        for ($i = 1; $i <= $number; $i++) {
            $tanggal = "$this->tahun-$this->bulan-$i";

            $nip = get_nip_from_ktp($row['no_ktp']);

            $exists = JkdJadwal::where('tanggal', $tanggal)->where("nip", $nip)->first();

            if ($exists) {
                $exists->update(['kode_jkd' => $row[$i]]);
            } else {
                JkdJadwal::create([
                    'kode_perusahaan' => kp(),
                    'kode_jkd' => $row[$i],
                    'nip' => $nip,
                    'tanggal' => $tanggal,
                ]);
            }
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'no_ktp' => Rule::exists('users', 'nik'),
        ];
    }

    public function customValidationMessages()
    {
        return [
            'no_pegawai.exists' => 'Pegawai tidak ditemukan!',
        ];
    }
}
