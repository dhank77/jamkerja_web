<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class JamKerjaStatisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $jadwal = "";
        foreach (get_jadwal($this->kode_jam_kerja) as $val) {
            if($val->jam_datang == "00:00" && $val->jam_pulang == "00:00"){
                $jadwal .= hari($val->hari) . " : Libur <br>";
            }else{
                $jadwal .= hari($val->hari) . " : " . "$val->jam_datang / $val->jam_pulang / $val->toleransi_datang / $val->toleransi_pulang <br>";
            }
        }
        return [
            'kode_jam_kerja' => $this->kode_jam_kerja,
            'nama' => $this->nama,
            'jadwal' => $jadwal,
            'jumlah_pegawai' => jumlah_pegawai_jks($this->kode_jam_kerja),
        ];
    }
}
