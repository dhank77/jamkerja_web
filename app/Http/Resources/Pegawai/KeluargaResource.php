<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class KeluargaResource extends JsonResource
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
            'nama' => $this->nama,
            'status' => ($this->status),
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => tanggal_indo($this->tanggal_lahir),
            'file' => storageNull($this->file_ktp),
        ];
    }
}
