<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\KelompokResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Kelompok;
use App\Models\Master\KelompokDetail;
use App\Models\User;
use Illuminate\Http\Request;

class KelompokPresensiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $qr = Kelompok::when($search, function ($qr, $search) {
                    $qr->where('nama', 'LIKE', "%$search%")
;
                })
                ->where('kode_perusahaan', kp())
                ->paginate($limit);
        $qr->appends(request()->all());

        $kelompok = KelompokResource::collection($qr);
        return inertia('Master/Kelompok/Index', compact('kelompok'));
    }

    public function getLokasi()
    {
        $qr = Kelompok::get();
        $kelompok = KelompokResource::collection($qr);

        return response()->json($kelompok);
    }

    public function add()
    {
        $kelompok = new Kelompok();
        $pegawai = User::role('pegawai')->orderBy('name')->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);

        $pegawai_select = [];

        return inertia('Master/Kelompok/Add', compact('kelompok', 'pegawai', 'pegawai_select'));
    }

    public function edit(Kelompok $kelompok)
    {

        $pegawai = User::role('pegawai')->orderBy('name')->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);

        $detail = KelompokDetail::where('kode_kelompok', $kelompok->kode_kelompok)->select('nip')->pluck('nip')->toArray();
        $pegawai_select = User::role('pegawai')->whereIn('nip', $detail)->orderBy('name')->get();
        $pegawai_select = SelectResource::collection($pegawai_select);
        
        return inertia('Master/Kelompok/Add', compact('kelompok', 'pegawai', 'pegawai_select'));
    }

    public function delete(Kelompok $kelompok)
    {
        $kelompok->delete();
        return redirect(route('kelompok.index'))->with([
            'type' => 'success',
            'messages' => 'Berhasil!'
        ]);
    }

    public function api_kelompok($kode)
    {
        $data = KelompokResource::make(kelompok::where('kode', $kode)->first());
        return response()->json($data);
    }

    public function store()
    {
        $kordinat = request('data')['kordinat'];
        $nama = request('data')['nama'];
        $jarak = request('data')['jarak'];
        $lat = request('data')['latitude'];
        $long = request('data')['longitude'];
        if($lat == "" && $long == ""){
            $ex = explode(',', $kordinat);
            $lat = trim($ex[0]);
            $long = trim($ex[1]);
        }
        $id = array_key_exists('kode_kelompok', request('data')) ? request('data')['kode_kelompok'] : null;

        if ($id) {
            $up = Kelompok::where('kode_kelompok', $id)
            ->update([
                'nama' => $nama,
                'kordinat' => $kordinat,
                'jarak' => $jarak,
                'lat' => $lat,
                'long' => $long,
            ]);

            $pegawai = request('pegawai');

            if(count($pegawai) > 0){
                KelompokDetail::where('kode_kelompok', $id)->delete();

                foreach ($pegawai as $p) {
                    KelompokDetail::updateOrCreate([
                            'nip' => $p['value']
                        ],
                        [
                            'kode_kelompok' => $id
                        ]);
                }
            }
        } else {
            $kode = generateUUID();
            $up = Kelompok::create([
                'kode_perusahaan' => kp(),
                'kode_kelompok' => $kode,
                'nama' => $nama,
                'kordinat' => $kordinat,
                'jarak' => $jarak,
                'lat' => $lat,
                'long' => $long,
            ]);

            $pegawai = request('pegawai');

            foreach ($pegawai as $p) {
                KelompokDetail::updateOrCreate([
                        'nip' => $p['value']
                    ],
                    [
                        'kode_kelompok' => $kode
                    ]);
            }
        }


        if ($up) {
            return redirect(route('master.kelompok.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil, Mengubah Data!'
            ]);
        } else {
            return redirect(route('master.kelompok.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal, Mengubah Data!'
            ]);
        }
    }
}
