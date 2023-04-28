<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardSakitResource extends JsonResource
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
            "name" => $this->name,
            "izin" => optional($this->izin)->nama,
            "cuti" => optional($this->cuti)->nama,
            "tanggal_mulai" => date_indo($this->tanggal_mulai),
            "tanggal_selesai" => date_indo($this->tanggal_selesai),
            "day" => dayBetween2Days($this->tanggal_mulai),
            "total" => dayBetween2Days($this->tanggal_mulai, $this->tanggal_selesai),
        ];
    }
}
