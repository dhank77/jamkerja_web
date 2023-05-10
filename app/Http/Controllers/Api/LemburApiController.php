<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Pengajuan\LemburPengajuanResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\User;

class LemburApiController extends Controller
{
    public function store()
    {
        $nip = request('nip');
        $tanggal = request('tanggal') ?? date("Y-m-d");
        $jam_mulai = request('jam_mulai');
        $jam_selesai = request('jam_selesai');
        $keterangan = request('keterangan');
        $file = request('file');

        $user = User::where('nip', $nip)->first();
        
        if($user){
            $file = uploadImage($file, "lembur/$nip");
            if ($file == "") {
                return response()->json(['status' => FALSE, 'messages' => 'Gambar Wajib dilampirkan!']);
            }
            $data = [
                'nip' => $nip,
                'tanggal' => $tanggal,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'keterangan' => $keterangan,
                'file' => $file,
                'kode_perusahaan' => kp()
            ];
            $cek = DataPengajuanLembur::where('nip', $nip)->where('status', 0)->count();
            if($cek > 0){
                return response()->json(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']);
            }
            
            $cr = DataPengajuanLembur::create($data);
            if($cr){
                tambah_log($cr->nip, "App\Models\Pegawai\DataPengajuanLembur", $cr->id, 'diajukan');    
                return response()->json(['status' => TRUE, 'messages' => 'Berhasil mengajukan!']);
            }else{
                return response()->json(['status' => FALSE, 'messages' => 'Server Erorr 405']);
            }

        }else{
            return response()->json(['status' => FALSE, 'messages' => 'User tidak ditemukan!']);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = DataPengajuanLembur::where('id', $id)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json([
                        'user' => PegawaiResource::make($user),
                        'data' => $dpc,
                    ]);
                }else{
                    return response()->json(['status' => FALSE ]);
                }
            }else{
                return response()->json(['status' => FALSE ]);
            }
        }else{
            return response()->json(['status' => FALSE ]);
        }
    }

    public function getHariIni()
    {
        $nip = request('nip');
        $tanggal = date("Y-m-d");
        if($nip){
            $dpc = DataPengajuanLembur::where('nip', $nip)->where('tanggal', $tanggal)->where("status", 1)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json([
                        'user' => PegawaiResource::make($user),
                        'data' => LemburPengajuanResource::make($dpc),
                    ]);
                }else{
                    return response()->json(['status' => FALSE ]);
                }
            }else{
                return response()->json(['status' => FALSE ]);
            }
        }else{
            return response()->json(['status' => FALSE ]);
        }
    }

    public function lists()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();
        if($user){
            $dpc = DataPengajuanLembur::where('nip', $nip)->paginate(10);
            if($dpc){
                    return response()->json([
                        'user' => PegawaiResource::make($user),
                        'data' => LemburPengajuanResource::collection($dpc),
                    ]);
            }else{
                return response()->json(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]);
            }
        }else{
            return response()->json(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]);
        }
    }
}
