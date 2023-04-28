<?php

namespace App\Http\Resources\Pegawai;

use App\Http\Resources\Master\EselonResource;
use App\Http\Resources\Master\JabatanResource as MasterJabatanResource;
use App\Http\Resources\Master\SkpdResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JabatanResource extends JsonResource
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
            'jabatan' => [
                'eselon' => ($this->tingkat?->eselon?->nama),
                'skpd' => $this->skpd?->nama,
                'nama' => $this->tingkat?->nama,
                'jenis' => jenis_jabatan($this->jenis_jabatan),
            ],
            'id' => $this->id,
            'nip' => $this->nip,
            'no_sk' => $this->no_sk,
            'tanggal_sk' => tanggal_indo($this->tanggal_sk),
            'tanggal_tmt' => tanggal_indo($this->tanggal_tmt),
            'sebagai' => $this->sebagai,
            'is_akhir' => $this->is_akhir,
            'file' => storageNull($this->file),
        ];
    }
}
