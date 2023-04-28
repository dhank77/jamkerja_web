<?php

namespace App\Http\Resources\Select;

use Illuminate\Http\Resources\Json\JsonResource;

class AtasanResource extends JsonResource
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
            'value' => $this->id,
            'kode_atasan' => $this->kode_jabatan,
            'label' => $this->nama,
        ];
    }
}
