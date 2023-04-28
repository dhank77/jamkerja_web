<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class JksPegawaiResource extends JsonResource
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
            'kode_jam_kerja' => $this->kode_jam_kerja,
            'nip' => $this->nip,
            'nama' => $this->user?->name,
            'image' => storage($this->user?->image),
        ];
    }
}
