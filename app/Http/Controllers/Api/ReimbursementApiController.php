<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Pengajuan\ReimbursementPengajuanResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Reimbursement;
use App\Models\Pegawai\DataPengajuanReimbursement;
use App\Models\User;

class ReimbursementApiController extends Controller
{
    public function index()
    {
        $reimbursement = Reimbursement::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $reimbursement = SelectResource::collection($reimbursement);
        return response()->json($reimbursement);
    }

    public function store()
    {
        $nip = request('nip');
        $kode_reimbursement = request('kode_reimbursement');
        $nilai = request('nilai');
        $keterangan = request('keterangan');
        $file = request('file');

        $user = User::where('nip', $nip)->first();
        if($user){
                $data = [
                    'nip' => $nip,
                    'kode_reimbursement' => $kode_reimbursement,
                    'nilai' => number_to_sql($nilai),
                    'keterangan' => $keterangan,
                    'file' => $file,
                    'kode_perusahaan' => kp()
                ];

                $cek = DataPengajuanReimbursement::where('nip', $nip)->where('status', 0)->count();
                if($cek > 0){
                    return response()->json(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']);
                }

                $cr = DataPengajuanReimbursement::create($data);
                if($cr){
                    tambah_log($cr->nip, "App\Models\Pegawai\DataPengajuanReimbursement", $cr->id, 'diajukan');    
                    return response()->json(['status' => TRUE]);
                }else{
                    return response()->json(['status' => FALSE]);
                }
        }else{
            return response()->json(['status' => FALSE]);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = DataPengajuanReimbursement::where('id', $id)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json([
                        'user' => PegawaiResource::make($user),
                        'data' => $dpc,
                    ]);
                }else{
                    return response()->json(['status' => FALSE]);
                }
            }else{
                return response()->json(['status' => FALSE]);
            }
        }else{
            return response()->json(['status' => FALSE]);
        }
    }

    public function lists()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();
        if($user){
            $dpc = DataPengajuanReimbursement::where('nip', $nip)->paginate(10);
            if($dpc){
                    return response()->json([
                        'user' => PegawaiResource::make($user),
                        'data' => ReimbursementPengajuanResource::collection($dpc),
                    ]);
            }else{
                return response()->json(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]);
            }
        }else{
            return response()->json(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]);
        }
    }
}
