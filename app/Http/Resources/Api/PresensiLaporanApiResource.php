<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PresensiLaporanApiResource extends JsonResource
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
            'nip' => $this->nip,
            'name' => $this->name,
            'jam_pagi' => $this->tanggal_datang ? date('H:i', strtotime($this->tanggal_datang)) : '-',
            'jam_siang' => $this->tanggal_istirahat ? date('H:i', strtotime($this->tanggal_istirahat)) : '-',
            'jam_sore' => $this->tanggal_pulang ? date('H:i', strtotime($this->tanggal_pulang)) : '-',
            'tanggal' => date('d', strtotime($this->created_at)) . " " . bulan(date('m', strtotime($this->created_at))) . " " . date('Y', strtotime($this->created_at))
        ];
    }
}
