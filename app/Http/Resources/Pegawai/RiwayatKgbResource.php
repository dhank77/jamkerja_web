<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatKgbResource extends JsonResource
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
            'nomor_surat' => $this->nomor_surat,
            'masa_kerja' => "$this->masa_kerja_tahun Tahun $this->masa_kerja_bulan Bulan",
            'gaji_pokok' => number_indo($this->gaji_pokok),
            'file' => storageNull($this->file),
            'tanggal_surat' => tanggal_indo($this->tanggal_surat),
            'is_akhir' => $this->is_akhir,
            'is_private' => $this->is_private,
            'tanggal_tmt' => tanggal_indo($this->tanggal_tmt),
        ];
    }
}
