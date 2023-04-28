<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class JabatanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'kode_skpd' => $this->kode_skpd,
            'skpd' => $this->skpd?->nama,

            'kode_bidang' => $this->kode_bidang,
            'bidang' => $this->bidang?->nama,

            'kode_seksi' => $this->kode_seksi,
            'seksi' => $this->seksi?->nama,
            
            'kode_atasan' => $this->kode_atasan,
            'atasan' => $this->atasan?->nama,
            
            'kode_jabatan' => $this->kode_jabatan,
            'nama' => $this->nama,

            'jenis_jabatan' => $this->jenis_jabatan,
            'jenis' => jenis_jabatan($this->jenis_jabatan),

            'kode_eselon' => $this->kode_eselon,
            'eselon' => $this->eselon?->nama,

            'batas_pensiun' => $this->batas_pensiun,
            'kelas_jabatan' => $this->kelas_jabatan,
            'kebutuhan' => $this->kebutuhan,
        ];
    }
}
