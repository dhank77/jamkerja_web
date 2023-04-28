<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Pengajuan\PengajuanIzinResource;
use App\Http\Resources\Select\SelectResource;
use App\Jobs\ProcessOneSignal;
use App\Jobs\ProcessWaNotif;
use App\Models\Master\Izin;
use App\Models\Pengajuan\PengajuanIzin;
use App\Models\User;

class IzinApiController extends Controller
{
    public function index()
    {
        $izin = Izin::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $izin = SelectResource::collection($izin);
        return response()->json($izin);
    }

    public function store()
    {
        $nip = request('nip');
        $kode_izin = request('kode_izin');
        $keterangan = request('keterangan');
        $tanggal_mulai = request('tanggal_mulai') ?? date("Y-m-d");
        $tanggal_selesai = request('tanggal_selesai') ?? date("Y-m-d");
        $file = request('file');

        $user = User::where('nip', $nip)->first();
        if ($user) {
            $file = uploadImage($file, "izin/$nip");
            if ($file == "") {
                return response()->json(['status' => FALSE, 'messages' => 'Gambar Wajib dilampirkan!']);
            }
            $data = [
                'nip' => $nip,
                'kode_izin' => $kode_izin,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'hari' => count(getBetweenDates($tanggal_mulai, $tanggal_selesai)),
                'keterangan' => $keterangan,
                'file' => $file,
            ];

            $cek = PengajuanIzin::where('nip', $nip)->where('status', 0)->count();
            if ($cek > 0) {
                return response()->json(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']);
            }

            $cr = PengajuanIzin::create($data);
            if ($cr) {
                $skpd = get_kode_skpd($nip);
                if($skpd != ""){
                    $users = User::where("kepala_divisi_id", $skpd)->get();
                    foreach ($users as $ux) {
                        dispatch(new ProcessWaNotif($ux->no_hp, "Hallo, $user->name telah mengajukan perizinan, segera verifikasi!"));
                    }
                }
                tambah_log($cr->nip, "App\Models\Pengajuan\PengajuanIzin", $cr->id, 'diajukan');
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
            $dpc = PengajuanIzin::where('id', $id)->first();
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
            $dpc = PengajuanIzin::where('nip', $nip)->paginate(10);
            if ($dpc) {
                return response()->json([
                    'user' => PegawaiResource::make($user),
                    'data' => PengajuanIzinResource::collection($dpc),
                ]);
            } else {
                return response()->json(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!']);
            }
        } else {
            return response()->json(['status' => FALSE, 'messages' => 'User tidak ditemukan!']);
        }
    }
}
