<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Pegawai\RiwayatShiftResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Shift;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;

class ShiftApiController extends Controller
{
    public function index()
    {
        $shift = Shift::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $shift = SelectResource::collection($shift);
        return response()->json($shift);
    }

    public function store()
    {
        $nip = request('nip');
        $kode_shift = request('kode_shift');
        $keterangan = request('keterangan');
        $file = request('file');

        $user = User::where('nip', $nip)->first();
        if($user){
                $data = [
                    'nip' => $nip,
                    'kode_shift' => $kode_shift,
                    'keterangan' => $keterangan,
                    'file' => $file,
                ];

                $cek = RiwayatShift::where('nip', $nip)->where('status', 0)->count();
                if($cek > 0){
                    return response()->json(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']);
                }

                $cr = RiwayatShift::create($data);
                if($cr){
                    tambah_log($cr->nip, "App\Models\Pegawai\RiwayatShift", $cr->id, 'diajukan');    
                    return response()->json(['status' => TRUE, 'messages' => 'Berhasil mengajukan!']);
                } else {
                    return response()->json(['status' => FALSE, 'messages' => 'Terjadi keselahan sistem!']);
                }
            } else {
                return response()->json(['status' => FALSE, 'messages' => 'Pegawai tidak ditemukan!']);
            }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = RiwayatShift::where('id', $id)->first();
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
            $dpc = RiwayatShift::where('nip', $nip)->where('status', '!=', 99)->paginate(10);
            if($dpc){
                    return response()->json([
                        'user' => PegawaiResource::make($user),
                        'data' => RiwayatShiftResource::collection($dpc),
                    ]);
            }else{
                return response()->json(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]);
            }
        }else{
            return response()->json(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]);
        }
    }
}
