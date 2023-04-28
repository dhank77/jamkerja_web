<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatShiftResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nip' => $this->nip,
            'nama' => $this?->name,
            'shift' => $this->shift?->nama,
            'nomor_surat' => $this->nomor_surat,
            'komentar' => $this->komentar,
            'is_akhir' => $this->is_akhir,
            'keterangan' => $this->keterangan,
            'status' => status_web($this->status),
            'status_api' => status($this->status),
            'kode_status' => ($this->status),
            'kode_status' => ($this->status),
            'file' => storageNull($this->file),
            'tanggal_surat' => tanggal_indo($this->tanggal_surat),
        ];
    }
}
