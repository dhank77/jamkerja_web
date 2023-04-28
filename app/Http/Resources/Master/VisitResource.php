<?php

namespace App\Http\Resources\Master;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
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
            'kode_visit' => $this->kode_visit,
            'nama' => $this->nama,
            'kordinat' => $this->kordinat,
            'jarak' => $this->jarak,
            'qr' => "data:image/png;base64, " . base64_encode(QrCode::format('png')->size(100)->generate($this->kode_visit)),
        ];
    }
}
