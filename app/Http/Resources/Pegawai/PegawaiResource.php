<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class PegawaiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $jabatan = array_key_exists('0', $this->jabatan_akhir->toArray()) ? $this->jabatan_akhir[0] : null;
        $tingkat = $jabatan?->tingkat;
        $nama_jabatan =  $tingkat?->nama;
        $eselon =  $tingkat?->eselon?->nama;
        $skpd = $jabatan?->skpd?->nama;

        $data = [
            'nip' => $this->nip,
            'no_hp' => $this->no_hp ?? "",
            'email' => $this->email ?? "",
            'name' => ($this->gelar_depan ? $this->gelar_depan .". " : "") . $this->name . ($this->gelar_belakang ? ", " . $this->gelar_belakang : ""),
            'nama_jabatan' => $nama_jabatan ?? "",
            'eselon' => $eselon ?? "",
            'skpd' => $skpd ?? "",
            'images' => $this->images,
            'tanggal_tmt' => tanggal_indo($this->tanggal_tmt),
        ];

        return $data;
    }
}
