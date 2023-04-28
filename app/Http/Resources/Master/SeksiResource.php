<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class SeksiResource extends JsonResource
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
            'kode_seksi' => $this->kode_seksi,
            'kode_bidang' => $this->kode_bidang,
            'kode_skpd' => $this->kode_skpd,
            'skpd' => $this->skpd?->nama,
            'bidang' => $this->bidang?->nama,
            'nama' => $this->nama,
            'singkatan' => $this->singkatan,
        ];
    }
}
