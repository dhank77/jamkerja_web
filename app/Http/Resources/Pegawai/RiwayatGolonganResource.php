<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatGolonganResource extends JsonResource
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
            'jeniskp' => $this->jeniskp->nama,
            'golongan' => $this->golongan->nama,
            'pangkat' => $this->golongan->pangkat,
            'tanggal_tmt' => tanggal_indo($this->tanggal_tmt),
            'tanggal_sk' => tanggal_indo($this->tanggal_sk),
            'no_sk' => $this->no_sk,
            'sk_bkn' => $this->sk_bkn,
            'tanggal_bkn' => $this->tanggal_bkn,
            'masa_bulan' => $this->masa_bulan,
            'masa_tahun' => $this->masa_tahun,
            'is_akhir' => $this->is_akhir,
            'file' => storageNull($this->file),
        ];
    }
}
