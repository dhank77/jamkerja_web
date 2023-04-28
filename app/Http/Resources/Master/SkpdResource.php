<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class SkpdResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'kode_skpd' => $this->kode_skpd,
            'singkatan' => $this->singkatan,
            'kordinat' => $this->kordinat,
            'jarak' => $this->jarak,
        ];
    }
}
