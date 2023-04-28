<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatStatusResource extends JsonResource
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
            'status' => $this->status->nama,
            'golongan' => $this->golongan->nama,
            'pangkat' => $this->golongan->pangkat,
            'tanggal_tmt' => tanggal_indo($this->tanggal_tmt),
            'tanggal_sk' => tanggal_indo($this->tanggal_sk),
            'no_sk' => $this->no_sk,
            'is_akhir' => $this->is_akhir,
            'file' => storageNull($this->file),
        ];
    }
}
