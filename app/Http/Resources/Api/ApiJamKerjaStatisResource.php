<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiJamKerjaStatisResource extends JsonResource
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
            'nama' => $this->nama,
            'hari' => hari($this->hari),
            'jam_datang' => $this->jam_datang,
            'jam_pulang' => $this->jam_pulang,
            'istirahat' => $this->istirahat . " Menit",
            'toleransi_datang' => $this->toleransi_datang . " Menit",
            'toleransi_pulang' => $this->toleransi_pulang . " Menit",
        ];
    }
}
