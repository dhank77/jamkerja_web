<?php

namespace App\Http\Resources\Select;

use Illuminate\Http\Resources\Json\JsonResource;

class SelectJkdMaster extends JsonResource
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
            'value' => $this->kode_jkd,
            'kode_jkd' => $this->kode_jkd,
            'label' => "$this->kode_jkd - $this->nama : $this->jam_datang - $this->jam_pulang",
        ];
    }
}
