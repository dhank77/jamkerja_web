<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\DataVisitResource;
use App\Models\Master\Visit;
use App\Models\Pegawai\DataVisit;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VisitApiController extends Controller
{
    public function store()
    {
        $nip = request('nip');
        $kordinat = request('kordinat');
        $kode_visit = request('kode_visit');

        $image_64 = request('image');
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = date("YmdHis") .  Str::random(10) . '.' . $extension;

        if($image_64){
            $foto = "visit/$nip/$imageName";
            Storage::disk('public')->put("/$foto", base64_decode($image));
        }else{
            $foto = "";
        }

        $timeZone = request('timezone') ?? 'WITA';

        if ($timeZone == 'WIB') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - (60 * 60));
        } elseif ($timeZone == 'WIT') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + (60 * 60));
        } else {
            $tanggalIn = date('Y-m-d H:i:s');
        }


        $user = User::where('nip', $nip)->first();
        if (!$user) {
            return response()->json(['status' => 'Error', 'messages' => 'User tidak ditemukan!']);
        }

        $cek = DataVisit::where('nip', $nip)->where('kode_visit', $kode_visit)->whereDate("tanggal", date("Y-m-d"))->count();

        if ($cek > 0) {
            return response()->json(['status' => 'Error', 'messages' => 'Anda Telah melakukan Visit Ke Lokasi Ini!']);
        } else {
            $data = [
                'nip' => $nip,
                'kode_visit' => $kode_visit,
                'kordinat' => $kordinat,
                'foto' => $foto,
                'tanggal' => $tanggalIn
            ];
            $cr = DataVisit::create($data);
            if ($cr) {
                return response()->json(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi Kunjungan!', 'keterangan' => 'pagi']);
            } else {
                return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
            }
        }
        
    }

    public function store_new()
    {
        $nip = request('nip');
        $judul = request('judul');
        $keterangan = request('keterangan');
        $kordinat = request('kordinat');
        $lokasi = request('lokasi');
        $file = request('image');

        $user = User::where('nip', $nip)->first();
        if ($user) {
            $file = uploadImage($file, "kunjungan/$nip");
            if ($file == "") {
                return response()->json(['status' => FALSE, 'messages' => 'Gambar Wajib dilampirkan!']);
            }
            $data = [
                'nip' => $nip,
                'judul' => $judul,
                'keterangan' => $keterangan,
                'kordinat' => $kordinat,
                'lokasi' => $lokasi,
                'foto' => $file,
            ];


            $cr = DataVisit::create($data);
            if ($cr) {
                tambah_log($cr->nip, "App\Models\Pegawai\DataVisit", $cr->id, 'laporan');
                return response()->json(['status' => TRUE, 'messages' => 'Berhasil memberikan laporan kunjungan!']);
            } else {
                return response()->json(['status' => FALSE, 'messages' => 'Terjadi Kesalahan!']);
            }
        } else {
            return response()->json(['status' => FALSE, 'messages' => 'Data tidak ditemukan!']);
        }
    }

    public function index()
    {
        $nip = request('nip');
        $date = request('mulai') ? date('Y-m-d', strtotime(request('mulai'))) : date('Y-m-d', strtotime('-1 days'));
        $end =  request('selesai') ? date('Y-m-d', strtotime(request('selesai')) + (60 * 60 * 24)) : date('Y-m-d', strtotime('+1 days'));

        $data = DataVisit::where('nip', $nip)->whereBetween('tanggal', [$date, $end])->latest()->get();
        $data = DataVisitResource::collection($data);

        return response()->json($data);
    }

    public function lokasi()
    {
        $kode = request('kode');

        $data = Visit::where('kode_visit', $kode)->first();
        if($data){
            $exp = explode(',', $data->kordinat);
            $data->latitude = (string) trim($exp[0]);
            $data->longitude = (string) trim($exp[1]);
            return response()->json($data);
        }

        return null;
    }
}
