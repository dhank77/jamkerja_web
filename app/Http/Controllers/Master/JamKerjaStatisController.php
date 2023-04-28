<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JamKerjaStatisResource;
use App\Models\Master\JamKerjaStatis;
use App\Models\Master\JksPegawai;
use Illuminate\Http\Request;

class JamKerjaStatisController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $jamKerjaStatis = JamKerjaStatis::when($search, function($qr, $search){
                                $qr->where('nama', 'LIKE', "%$search%");
                            })
                            ->select('nama', 'kode_jam_kerja')
                            ->distinct('kode_jam_kerja')
                            ->paginate($limit);

        $jamKerjaStatis->appends(request()->all());

        $jamKerjaStatis = JamKerjaStatisResource::collection($jamKerjaStatis);

        return inertia('Master/JamKerjaStatis/Index', compact('jamKerjaStatis'));
    }


    public function add()
    {
        return inertia('Master/JamKerjaStatis/Add');
    }

    public function edit($kode_jam_kerja)
    {
        $jamKerjaStatis = JamKerjaStatis::where('kode_jam_kerja', $kode_jam_kerja)->orderBy('hari')->get();
        return inertia('Master/JamKerjaStatis/Edit', compact('jamKerjaStatis'));
    }

    public function delete($kode_jam_kerja)
    {
        JksPegawai::where('kode_jam_kerja', $kode_jam_kerja)->delete();
        $cr = JamKerjaStatis::where('kode_jam_kerja', $kode_jam_kerja)->delete();
        if ($cr) {
            return redirect(route('master.jamKerjaStatis.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jamKerjaStatis.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
        ];

        request()->validate($rules);

        $kode_jam_kerja = request('kode_jam_kerja');
        if(!$kode_jam_kerja){
            $kode_jam_kerja = rand(0001, 9999);
        }else{
            JamKerjaStatis::where('kode_jam_kerja', $kode_jam_kerja)->delete();
        }
        foreach (request('data') as $val) {
            $val['kode_jam_kerja'] = $kode_jam_kerja;
            $val['nama'] = request('nama');
            $cr = JamKerjaStatis::create($val);
        }

        if ($cr) {
            return redirect(route('master.jamKerjaStatis.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jamKerjaStatis.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
