<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class JkdMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'kode_jkd' => $this->kode_jkd,
            'nama' => $this->nama,
            'jam_datang' => $this->jam_datang,
            'jam_pulang' => $this->jam_pulang,
            'istirahat' => $this->istirahat . " Menit",
            'toleransi_datang' => $this->toleransi_datang . " Menit",
            'toleransi_pulang' => $this->toleransi_pulang . " Menit",
            'color_code' => str_replace("#", "0xFF", strtoupper($this->color)),
            'color' => '<div style="background-color: '. $this->color .'; width:40px; height:40px; font-size:26px; text-align: center; margin:auto;">1</div>',
        ];
    }
}
