<?php

namespace App\Http\Resources\Payroll;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneratePayrollResource extends JsonResource
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
            'kode_payroll' => $this->kode_payroll,
            'skpd' => $this->kode_skpd == "" ? "Semua Divisi Kerja" : get_skpd($this->kode_skpd),
            'bulan' => bulan($this->bulan) . " $this->tahun",
            'status' => is_aktif($this->is_aktif),
        ];
    }
}
