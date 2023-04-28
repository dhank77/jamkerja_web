<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatSptResource extends JsonResource
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
            'tahun' => $this->tahun,
            'jenis_spt' => $this->jenis_spt,
            'status_spt' => $this->status_spt,
            'nomor_tanda_terima_elektronik' => $this->nomor_tanda_terima_elektronik,
            'nominal' => number_indo($this->nominal),
            'file' => storageNull($this->file),
            'tanggal_penyampaian' => tanggal_indo($this->tanggal_penyampaian),
        ];
    }
}
