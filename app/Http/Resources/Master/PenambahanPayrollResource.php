<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class PenambahanPayrollResource extends JsonResource
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
            'nama' => $this->nama,
            'satuan' => $this->satuan,
            'nilai' => number_indo($this->nilai) . " (" . satuan($this->satuan) . ") ",
            'dari' => ($this->satuan == 2 ? master_tunjangan($this->kode_persen) : ""),
        ];
    }
}
