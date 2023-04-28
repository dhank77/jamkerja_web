<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class PosisiResource extends JsonResource
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

        $status         = $this?->status?->nama;
        $skpd           =  $jabatan?->skpd?->nama;
        $eselon           =  $jabatan?->tingkat?->eselon?->nama;
        $parents        =  $jabatan?->tingkat?->parents;
        $tmt_jabatan    =  $jabatan?->tanggal_tmt;
        $jenis_jabatan  =  $jabatan?->jenis_jabatan;
        $nama_jabatan        =  $jabatan?->tingkat?->nama;

        $sk_jabatan_terlama = $this->riwayat_jabatan()->orderBy('tanggal_sk')->value('tanggal_sk');

        $data = [
            'nip' => $this->nip,
            'name' => $this->name,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'skpd' => $skpd,
            'level' => $eselon,
            'status' => $status,
            'parents' => $parents,
            'jabatan' => $nama_jabatan,
            'images' => $this->images,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'tmt_jabatan' => $tmt_jabatan ? tanggal_indo($tmt_jabatan) : "",
            'jenis_jabatan' => jenis_jabatan($jenis_jabatan),
            'masa_kerja' => get_masa_kerja($sk_jabatan_terlama)
        ];



        return $data;
    }
}
