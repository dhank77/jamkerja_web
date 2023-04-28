<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Pengajuan\CutiPengajuanResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Master\Cuti;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\User;
use Illuminate\Http\Request;

class CutiApiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $cuti = SelectResource::collection($cuti);
        return response()->json($cuti);
    }

    public function tahunan()
    {
        $nip = request('nip');

        $jatah = User::where('nip', $nip)->value('cuti_tahunan');
        // $cuti = DataPengajuanCuti::where('nip', $nip)
        //                                 ->where('status', 1)
        //                                 ->where('kode_cuti', 19)
        //                                 ->whereYear('tanggal_mulai', date('Y'))
        //                                 ->get();
        // $terpakai = 0;
        // foreach ($cuti as $c) {
        //    $hari = get_between_dates($c->tanggal_mulai, $c->tanggal_selesai);
        //    $terpakai += count($hari);
        // }

        $terpakai = DataPengajuanCuti::where('nip', $nip)
                                        ->where('status', 1)
                                        ->where('kode_cuti', 19)
                                        ->whereYear('tanggal_mulai', date('Y'))
                                        ->sum('hari');

        return response()->json([
            'jatah' => $jatah,
            'terpakai' => $terpakai,
            'sisa' => $jatah - $terpakai,
        ]);
    }

    public function store()
    {
        $nip = request('nip');
        $keterangan = request('keterangan');
        $kode_cuti = request('kode_cuti');
        $tanggal_mulai = request('tanggal_mulai') ?? date("Y-m-d");
        $tanggal_selesai = request('tanggal_selesai') ?? date("Y-m-d");
        $file = request('file');

        $user = User::where('nip', $nip)->first();
        if($user){
                $file = uploadImage($file, "cuti/$nip");
                if ($file == "") {
                    return response()->json(['status' => FALSE, 'messages' => 'Gambar Wajib dilampirkan!']);
                }
                $hari = count(getBetweenDates($tanggal_mulai, $tanggal_selesai));
                $data = [
                    'nip' => $nip,
                    'kode_cuti' => $kode_cuti,
                    'tanggal_mulai' => $tanggal_mulai,
                    'tanggal_selesai' => $tanggal_selesai,
                    'hari' => $hari,
                    'keterangan' => $keterangan,
                    'file' => $file,
                ];

                $cek = DataPengajuanCuti::where('nip', $nip)->where('status', 0)->count();
                if($cek > 0){
                    return response()->json(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']);
                }

                if($kode_cuti == '19'){

                    if($user->cuti_tahunan < 1){
                        return response()->json(['status' => FALSE, 'messages' => "Anda tidak memiliki cuti tahunan!"]);
                    }

                    //jumlah yang telah diambil 
                    $telah_diambil = DataPengajuanCuti::where('nip', $nip)
                                        ->where('status', 1)
                                        ->where('kode_cuti', 19)
                                        ->whereYear('tanggal_mulai', date('Y', strtotime($tanggal_mulai)))
                                        ->sum('hari'); 

                    if(($telah_diambil + $hari) > $user->cuti_tahunan){
                        $sisa = $user->cuti_tahunan - $telah_diambil;

                        return response()->json(['status' => FALSE, 'messages' => "Data cuti yang dapat di ambil hanya $sisa hari!"]);
                    }
                }

                $cr = DataPengajuanCuti::create($data);
                if($cr){
                    $skpd = get_kode_skpd($nip);
                    if($skpd != ""){
                        $users = User::where("kepala_divisi_id", $skpd)->get();
                        foreach ($users as $ux) {
                            dispatch(new ProcessWaNotif($ux->no_hp, "Hallo, $user->name telah mengajukan cuti, segera verifikasi!"));
                        }
                    }
                    tambah_log($cr->nip, "App\Models\Pegawai\DataPengajuanCuti", $cr->id, 'diajukan');    
                    return response()->json(['status' => TRUE, 'messages' => 'Berhasil mengajukan!']);
                }else{
                    return response()->json(['status' => FALSE, 'messages' => 'Terjadi Kesalahan sistem!']);
                }
        }else{
            return response()->json(['status' => FALSE, 'messages' => 'Data tidak ditemukan!']);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = DataPengajuanCuti::where('id', $id)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json([
                        'status' => TRUE,
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
            $dpc = DataPengajuanCuti::where('nip', $nip)->paginate(10);
            if($dpc){
                    return response()->json([
                        'user' => PegawaiResource::make($user),
                        'data' => CutiPengajuanResource::collection($dpc),
                    ]);
            }else{
                return response()->json(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]);
            }
        }else{
            return response()->json(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]);
        }
    }


}
