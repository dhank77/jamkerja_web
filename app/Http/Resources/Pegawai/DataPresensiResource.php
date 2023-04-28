<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class DataPresensiResource extends JsonResource
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
            'nama' => $this->nama,
            'nip' => $this->nip,
            'jabatan' => get_jabatan_from_nip($this->nip),
            'image_datang' => storageNull($this->image_datang),
            'image_pulang' => storageNull($this->image_pulang),
            'tanggal' => tanggal_indo($this->tanggal),
            'jam_datang' => get_jam(date("Y-m-d"). " " . $this->jam_datang),
            'jam_pulang' => get_jam(date("Y-m-d"). " " . $this->jam_pulang),
            'jam_istirahat_mulai' => get_jam(date("Y-m-d"). " " . $this->jam_istirahat_mulai),
            'jam_istirahat_selesai' => get_jam(date("Y-m-d"). " " . $this->jam_istirahat_selesai),
        ];
    }
}
