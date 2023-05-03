<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollLemburResource extends JsonResource
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
            'kode_lembur' => $this->kode_lembur,
            'pengali' => $this->pengali,
            'jam' => $this->jam,
            'kode_tunjangan' => $this->kode_tunjangan,
            'tunjangan' => master_tunjangan($this->kode_tunjangan),
        ];
    }
}
