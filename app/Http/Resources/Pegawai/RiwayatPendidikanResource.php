<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatPendidikanResource extends JsonResource
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
            'pendidikan' => [
                'kode_pendidikan' => $this->kode_pendidikan,
                'nama' => $this->pendidikan->nama,
            ],
            'jurusan' => [
                'kode_jurusan' => $this->kode_jurusan,
                'nama' => $this->jurusan?->nama,
            ],
            'nomor_ijazah' => $this->nomor_ijazah,
            'is_akhir' => $this->is_akhir,
            'tanggal_lulus' => tanggal_indo($this->tanggal_lulus),
            'nama_sekolah' => $this->nama_sekolah,
            'file' => storageNull($this->file),
        ];
    }
}
