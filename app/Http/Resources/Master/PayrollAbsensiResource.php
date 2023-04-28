<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollAbsensiResource extends JsonResource
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
            'pengali' => $this->pengali,
            'menit' => $this->menit,
            'keterangan' => $this->keterangan == 1 ? "Telat $this->menit Menit" : "Cepat Pulang $this->menit Menit",
            'kode_tunjangan' => $this->kode_tunjangan,
            'tunjangan' => master_tunjangan($this->kode_tunjangan),
        ];
    }
}
