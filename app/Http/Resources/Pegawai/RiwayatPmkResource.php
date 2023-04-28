<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatPmkResource extends JsonResource
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
            'jenis_pmk' => ucfirst($this->jenis_pmk),
            'instansi' => $this->instansi,
            'nomor_sk' => $this->nomor_sk,
            'nomor_bkn' => $this->nomor_bkn,
            'masa_kerja' => "$this->masa_kerja_tahun Tahun $this->masa_kerja_bulan Bulan",
            'file' => storageNull($this->file),
            'tanggal_sk' => tanggal_indo($this->tanggal_sk),
            'tanggal_awal' => tanggal_indo($this->tanggal_awal),
            'tanggal_akhir' => tanggal_indo($this->tanggal_akhir),
            'tanggal_bkn' => tanggal_indo($this->tanggal_bkn),
        ];
    }
}
