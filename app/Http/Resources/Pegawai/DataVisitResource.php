<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class DataVisitResource extends JsonResource
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
            'kode_visit' => $this->kode_visit,
            'visit' => $this->visit?->nama,
            'judul' => $this->judul,
            'keterangan' => $this->keterangan,
            'kordinat' => $this->kordinat,
            'lokasi' => $this->lokasi,
            'tanggal' => tanggal_indo($this->tanggal),
            'jam' => get_jam($this->tanggal),
            'foto' => storageNull($this->foto),
        ];
    }
}
