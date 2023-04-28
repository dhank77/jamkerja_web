<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatKursusResource extends JsonResource
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
            'tempat' => $this->tempat,
            'kursus' => $this->kursus->nama,
            'pelaksana' => $this->pelaksana,
            'angkatan' => $this->angkatan,
            'jumlah_jp' => $this->jumlah_jp,
            'no_sertifikat' => $this->no_sertifikat,
            'file' => storageNull($this->file),
            'tanggal_mulai' => tanggal_indo($this->tanggal_mulai),
            'tanggal_selesai' => tanggal_indo($this->tanggal_selesai),
            'tanggal_sertifikat' => tanggal_indo($this->tanggal_sertifikat),
        ];
    }
}
