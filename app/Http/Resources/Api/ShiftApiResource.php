<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ShiftApiResource extends JsonResource
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
            'kode_shift' => $this->kode_shift,
            'kode_tingkat' => $this->kode_tingkat,
            'jam_buka_datang' => strtotime(date("Y-m-d") . " " . $this->jam_buka_datang),
            'jam_tutup_datang' => strtotime(date("Y-m-d") . " " . $this->jam_tutup_datang),
            'jam_buka_istirahat' => $this->jam_buka_istirahat ? strtotime(date("Y-m-d") . " " . $this->jam_buka_istirahat) : 0,
            'jam_tutup_istirahat' => $this->jam_tutup_istirahat ? strtotime(date("Y-m-d") . " " . $this->jam_tutup_istirahat) : 0,
            'jam_buka_pulang' => strtotime(date("Y-m-d") . " " . $this->jam_buka_pulang),
            'jam_tutup_pulang' => strtotime(date("Y-m-d") . " " . $this->jam_tutup_pulang),
        ];
    }
}
