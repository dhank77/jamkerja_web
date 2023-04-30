<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JksPegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\JksPegawai;
use App\Models\User;
use Illuminate\Http\Request;

class JksPegawaiController extends Controller
{
    public function index($kode_jam_kerja)
    {
        $jks = JksPegawai::with('user')->where('kode_jam_kerja', $kode_jam_kerja)->get();
        JksPegawaiResource::withoutWrapping();
        $jks = JksPegawaiResource::collection($jks);

        return response()->json($jks);
    }

    public function all_free()
    {
        $jks = User::role('pegawai')->select("users.nip", "users.name", "users.image")->leftJoin('jks_pegawai', 'jks_pegawai.nip', 'users.nip')->whereNull('jks_pegawai.id')->where('users.kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $jks = SelectResource::collection($jks);

        return response()->json($jks);
    }

    public function delete($nip)
    {
        JksPegawai::where('nip', $nip)->delete();
        return redirect()->back();
    }

    public function store()
    {
        $kode_jam_kerja = request('kode_jam_kerja');
        foreach (request('checked') as $nip) {
            JksPegawai::updateOrCreate(
                [
                    'nip' => $nip,
                    'kode_perusahaan' => kp(),
                ],
                [
                    'kode_jam_kerja' => $kode_jam_kerja,
                ]
            );
        }

        return redirect()->back();
    }
}
