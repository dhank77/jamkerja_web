<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatLainnyaResource extends JsonResource
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
            'lainnya' => $this->lainnya->nama,
            'nomor_sk' => $this->nomor_sk,
            'file' => storageNull($this->file),
            'tanggal_sk' => tanggal_indo($this->tanggal_sk),
        ];
    }
}
