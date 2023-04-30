<?php

namespace App\Http\Resources\Select;

use Illuminate\Http\Resources\Json\JsonResource;

class SelectResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'value' => $this->id,
            'label' => $this->nama,
        ];

        if($this->kode_jabatan){
            $data['kode_jabatan'] = $this->kode_jabatan;
        }
        if($this->kode_suku){
            $data['kode_suku'] = $this->kode_suku;
        }
        if($this->kode_skpd){
            $data['kode_skpd'] = $this->kode_skpd;
        }
        if($this->kode_eselon){
            $data['kode_eselon'] = $this->kode_eselon;
        }else{
            if($this->tingkat){
                $data['tingkat'] = $this->tingkat;
            }
        }
        if($this->kode_status){
            $data['kode_status'] = $this->kode_status;
        }
        if($this->kode_golongan){
            $data['kode_golongan'] = $this->kode_golongan;
            $data['label'] = $this->nama . " - " . $this->pangkat;
        }
        if($this->kode_kp){
            $data['kode_kp'] = $this->kode_kp;
        }
        if($this->kode_pendidikan){
            $data['kode_pendidikan'] = $this->kode_pendidikan;
        }
        if($this->kode_jurusan){
            $data['kode_jurusan'] = $this->kode_jurusan;
        }
        if($this->kode_bidang){
            $data['kode_bidang'] = $this->kode_bidang;
        }
        if($this->kode_seksi){
            $data['kode_seksi'] = $this->kode_seksi;
        }
        if($this->kode_diklat_struktural){
            $data['kode_diklat_struktural'] = $this->kode_diklat_struktural;
        }
        if($this->kode_kursus){
            $data['kode_kursus'] = $this->kode_kursus;
        }
        if($this->kode_penghargaan){
            $data['kode_penghargaan'] = $this->kode_penghargaan;
        }
        if($this->kode_cuti){
            $data['kode_cuti'] = $this->kode_cuti;
        }
        if($this->kode_lainnya){
            $data['kode_lainnya'] = $this->kode_lainnya;
        }
        if($this->kode_lokasi){
            $data['kode_lokasi'] = $this->kode_lokasi;
        }
        if($this->kode_shift){
            $data['kode_shift'] = $this->kode_shift;
        }
        if($this->kode_reimbursement){
            $data['kode_reimbursement'] = $this->kode_reimbursement;
        }
        if($this->kode_tunjangan){
            $data['kode_tunjangan'] = $this->kode_tunjangan;
        }
        if($this->kode_potongan){
            $data['kode_potongan'] = $this->kode_potongan;
        }
        if($this->kode_tambah){
            $data['kode_tambah'] = $this->kode_tambah;
        }
        if($this->kode_kurang){
            $data['kode_kurang'] = $this->kode_kurang;
        }
        if($this->kode_izin){
            $data['kode_izin'] = $this->kode_izin;
        }
        if($this->kode_ijin){
            $data['kode_ijin'] = $this->kode_ijin;
        }
        if($this->nip){
            $data['nip'] = $this->nip;
            $data['value'] = $this->nip;
            $data['label'] = $this->name_wg;
            $data['images'] = storage($this->image);
        }

        return $data;
    }
}
