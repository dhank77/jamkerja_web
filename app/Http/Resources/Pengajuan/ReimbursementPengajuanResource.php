<?php

namespace App\Http\Resources\Pengajuan;

use Illuminate\Http\Resources\Json\JsonResource;

class ReimbursementPengajuanResource extends JsonResource
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
            'nip' => $this->nip,
            'nama' => $this->name,
            'reimbursement' => optional($this->reimbursement)->nama,
            'nilai' => number_indo($this->nilai),
            'keterangan' => $this->keterangan ?? "",
            'status' => status_web($this->status),
            'tanggal_surat' => tanggal_indo($this->tanggal_surat),
            'nomor_surat' => ($this->nomor_surat),
            'kode_status' => ($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => storageNull($this->file),
        ];
    }
}
