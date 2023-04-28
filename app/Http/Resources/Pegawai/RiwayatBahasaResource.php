<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatBahasaResource extends JsonResource
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
            'nama_bahasa' => $this->nama_bahasa,
            'penguasaan' => ucfirst($this->penguasaan),
            'jenis' => ucfirst($this->jenis),
            'file' => storageNull($this->file),
        ];
    }
}
