<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Pengajuan\PengajuanIjinResource;
use App\Http\Resources\Select\SelectResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Master\Ijin;
use App\Models\Pengajuan\PengajuanIjin;
use App\Models\User;

class IjinApiController extends Controller
{
    public function index()
    {
        $ijin = Ijin::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $ijin = SelectResource::collection($ijin);
        return response()->json($ijin);
    }

    public function store()
    {
        $nip = request('nip');
        $kode_ijin = request('kode_ijin');
        $keterangan = request('keterangan');
        $tanggal_mulai = request('tanggal_mulai');
        $tanggal_selesai = request('tanggal_selesai');
        $file = request('file');

        $user = User::where('nip', $nip)->first();
        if ($user) {
            $file = uploadImage($file, "ijin/$nip");
            if ($file == "") {
                return response()->json(['status' => FALSE, 'messages' => 'Gambar Wajib dilampirkan!']);
            }
            $data = [
                'nip' => $nip,
                'kode_ijin' => $kode_ijin,
                'tanggal_mulai' => date("Y-m-d H:i:s", strtotime(date("Y-m-d") . " " . $tanggal_mulai)),
                'tanggal_selesai' => date("Y-m-d H:i:s", strtotime(date("Y-m-d") . " " . $tanggal_selesai)),
                'keterangan' => $keterangan,
                'hari' => 1,
                'file' => $file,
            ];

            $cek = PengajuanIjin::where('nip', $nip)->where('status', 0)->count();
            if ($cek > 0) {
                return response()->json(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']);
            }

            $cr = PengajuanIjin::create($data);
            if ($cr) {
                $skpd = get_kode_skpd($nip);
                if($skpd != ""){
                    $users = User::where("kepala_divisi_id", $skpd)->get();
                    foreach ($users as $ux) {
                        dispatch(new ProcessWaNotif($ux->no_hp, "Hallo, $user->name telah mengajukan perijinan, segera verifikasi!"));
                    }
                }
                tambah_log($cr->nip, "App\Models\Pengajuan\PengajuanIjin", $cr->id, 'diajukan');
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
        if ($id) {
            $dpc = PengajuanIjin::where('id', $id)->first();
            if ($dpc) {
                $user = User::where('nip', $dpc->nip)->first();
                if ($user) {
                    return response()->json([
                        'status' => TRUE,
                        'user' => PegawaiResource::make($user),
                        'data' => $dpc,
                    ]);
                } else {
                    return response()->json(['status' => FALSE]);
                }
            } else {
                return response()->json(['status' => FALSE]);
            }
        } else {
            return response()->json(['status' => FALSE]);
        }
    }

    public function lists()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();
        if ($user) {
            $dpc = PengajuanIjin::where('nip', $nip)->paginate(10);
            if ($dpc) {
                return response()->json([
                    'user' => PegawaiResource::make($user),
                    'data' => PengajuanIjinResource::collection($dpc),
                ]);
            } else {
                return response()->json(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!']);
            }
        } else {
            return response()->json(['status' => FALSE, 'messages' => 'User tidak ditemukan!']);
        }
    }
}
