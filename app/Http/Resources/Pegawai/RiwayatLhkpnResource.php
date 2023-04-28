<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatLhkpnResource extends JsonResource
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
            'jenis_form' => $this->jenis_form,
            'keterangan' => $this->keterangan,
            'file' => storageNull($this->file),
            'tanggal_pelaporan' => tanggal_indo($this->tanggal_pelaporan),
        ];
    }
}
