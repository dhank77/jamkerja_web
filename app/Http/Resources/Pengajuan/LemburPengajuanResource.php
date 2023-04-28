<?php

namespace App\Http\Resources\Pengajuan;

use Illuminate\Http\Resources\Json\JsonResource;

class LemburPengajuanResource extends JsonResource
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
            'nama' => $this->name,
            'tanggal' => tanggal_indo($this->tanggal),
            'jam_mulai' => ($this->jam_mulai),
            'jam_selesai' => ($this->jam_selesai),
            'keterangan' => $this->keterangan ?? "",
            'status' => status_web($this->status),
            'kode_status' => ($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => storageNull($this->file),
        ];
    }
}
