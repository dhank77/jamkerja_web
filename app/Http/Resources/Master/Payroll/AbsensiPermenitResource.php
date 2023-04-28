<?php

namespace App\Http\Resources\Master\Payroll;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiPermenitResource extends JsonResource
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
            'level' => $this->eselon?->nama ?? "Semua Level",        
            'potongan' => "Rp. " .  number_indo($this->potongan),        
            'keterangan' => strtoupper($this->keterangan),        
        ];  
    }
}
