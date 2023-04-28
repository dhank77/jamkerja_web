<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatPotonganResource extends JsonResource
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
            'potongan' => $this->potongan?->nama,
            'tanggal_sk' => tanggal_indo($this->tanggal_sk),
            'nomor_sk' => $this->nomor_sk,
            'status' => is_aktif($this->is_aktif),
            'is_aktif' => ($this->is_aktif),
            'is_private' => $this->is_private,
            'file' => storageNull($this->file),
        ];
    }
}
