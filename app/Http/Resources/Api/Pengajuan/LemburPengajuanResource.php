<?php

namespace App\Http\Resources\Api\Pengajuan;

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
            'jam_mulai' => get_jam($this->jam_mulai),
            'jam_selesai' => get_jam($this->jam_selesai),
            'time_jam_mulai' => strtotime("$this->tanggal $this->jam_mulai"),
            'time_jam_selesai' => strtotime("$this->tanggal $this->jam_selesai"),
            'tanggal' => tanggal_indo($this->tanggal),
            'keterangan' => $this->keterangan ?? "",
            'status' => status($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => storageNull($this->file),
        ];
    }
}
