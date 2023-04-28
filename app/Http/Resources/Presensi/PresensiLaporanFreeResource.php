<?php

namespace App\Http\Resources\Presensi;

use Illuminate\Http\Resources\Json\JsonResource;

class PresensiLaporanFreeResource extends JsonResource
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
            'nama' => $this->name,
            'nip' => $this->nip,
            'tanggal' => tanggal_indo($this->tanggal),
            'jam_datang' => get_jam($this->tanggal . " " .$this->jam_datang),
            'kordinat_datang' => $this->kordinat_datang,
            'image_datang' => storageNull($this->image_datang),
            'jam_pulang' => get_jam($this->tanggal . " " .$this->jam_pulang),
            'kordinat_pulang' => $this->kordinat_pulang,
            'image_pulang' => storageNull($this->image_pulang),
            'waktu_istirahat' => menit_dari_2jam($this->jam_istirahat_mulai, $this->jam_istirahat_selesai),
            'jam_istirahat_mulai' => get_jam($this->jam_istirahat_mulai),
            'jam_istirahat_selesai' => get_jam($this->jam_istirahat_selesai),
        ];
    }
}
