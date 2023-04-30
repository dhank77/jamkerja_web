<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class JkdJadwalResource extends JsonResource
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
            'nama' => $this->user?->name,
            'kode_jkd' => $this->kode_jkd,
            'nama_jkd' => $this->jkd_master?->nama,
            'tanggal' => tanggal_indo($this->tanggal),
        ];
    }
}
