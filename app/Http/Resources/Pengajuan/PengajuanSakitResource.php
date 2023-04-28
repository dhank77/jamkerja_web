<?php

namespace App\Http\Resources\Pengajuan;

use Illuminate\Http\Resources\Json\JsonResource;

class PengajuanSakitResource extends JsonResource
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
            'tanggal_mulai' => tanggal_indo($this->tanggal_mulai),
            'tanggal_selesai' => tanggal_indo($this->tanggal_selesai),
            'tanggal_mulai_api' => date_indo($this->tanggal_mulai),
            'tanggal_selesai_api' => date_indo($this->tanggal_selesai),
            'keterangan' => $this->keterangan ?? "",
            'status' => status_web($this->status),
            'kode_status' => ($this->status),
            'status_api' => status($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => storageNull($this->file),
        ];
    }
}
