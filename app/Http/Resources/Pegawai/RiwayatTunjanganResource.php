<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatTunjanganResource extends JsonResource
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
            'tunjangan' => $this->tunjangan?->nama,
            'tanggal_sk' => tanggal_indo($this->tanggal_sk),
            'nomor_sk' => $this->nomor_sk,
            'nilai' => number_indo($this->nilai),
            'status' => is_aktif($this->is_aktif),
            'is_aktif' => ($this->is_aktif),
            'is_private' => $this->is_private,
            'file' => storageNull($this->file),
        ];
    }
}
