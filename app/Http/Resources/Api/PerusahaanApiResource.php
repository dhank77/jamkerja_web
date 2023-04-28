<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PerusahaanApiResource extends JsonResource
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
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'kontak' => $this->kontak,
            'logo' => storage($this->logo),
            'direktur' => $this->direktur,
            'nomor' => $this->nomor,
        ];
    }
}
