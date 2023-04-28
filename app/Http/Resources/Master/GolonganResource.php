<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class GolonganResource extends JsonResource
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
            'kode_golongan' => $this->kode_golongan,
            'pangkat' => $this->pangkat,
            'nama' => $this->nama,
            'nama_abjad' => $this->nama_abjad,
        ];
    }
}
