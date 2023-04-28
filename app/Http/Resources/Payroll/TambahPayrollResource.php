<?php

namespace App\Http\Resources\Payroll;

use Illuminate\Http\Resources\Json\JsonResource;

class TambahPayrollResource extends JsonResource
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
            'kode_tambah' => $this->kode_tambah,
            'tambah' => $this->tambah?->nama,
            'keterangan' => keterangan($this->keterangan),
            'detail' => detail_keterangan($this->keterangan, $this->kode_keterangan),
            'tanggal' => $this->is_periode == 1 ? bulan($this->bulan) . " / " . $this->tahun : "Selamanya",
        ];
    }
}
