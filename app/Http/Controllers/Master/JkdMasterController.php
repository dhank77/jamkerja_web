<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JkdMasterResource;
use App\Http\Resources\Select\SelectJkdMaster;
use App\Models\Master\JkdMaster;

class JkdMasterController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $jkdMaster = JkdMaster::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->where('kode_perusahaan', kp())
                ->orWhereNull('kode_perusahaan')
                ->paginate($limit);

        $jkdMaster->appends(request()->all());

        $jkdMaster = JkdMasterResource::collection($jkdMaster);

        return inertia('Master/JkdMaster/Index', compact('jkdMaster'));
    }


    public function add()
    {
        $jkdMaster = new JkdMaster();
        return inertia('Master/JkdMaster/Add', compact('jkdMaster'));
    }

    public function edit(JkdMaster $jkdMaster)
    {
        return inertia('Master/JkdMaster/Add', compact('jkdMaster'));
    }

    public function delete(JkdMaster $jkdMaster)
    {
        $cr = $jkdMaster->delete();
        if ($cr) {
            return redirect(route('master.jamKerjaDinamis.jkdMaster.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jamKerjaDinamis.jkdMaster.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'jam_datang' => 'required',
            'jam_pulang' => 'required',
            'istirahat' => 'required',
            'color' => 'required',
            'toleransi_datang' => 'nullable',
            'toleransi_pulang' => 'nullable',
        ];

        $data = request()->validate($rules);

        if(!request('id')){
            $array = explode(' ', request('nama'));
            if(count($array) > 1){
                $str = "";
                foreach ($array as $a) {
                    $str .= strtoupper(substr($a, 0, 1));
                }
                $kode_jkd = $str . rand(1111, 9999);
            }else{
                $kode_jkd = strtoupper(substr(request('nama'), 0, 2)) . rand(1111, 9999);
            }
            $cek = JkdMaster::where('kode_jkd', $kode_jkd)->first();
            if($cek){
                return redirect(route('master.jamKerjaDinamis.jkdMaster.index'))->with([
                    'type' => 'error',
                    'messages' => "Terjadi Kesalahan, silahkan simpan kembali!"
                ]);
            }  
            $data['kode_jkd'] = $kode_jkd;
            $data['kode_perusahaan'] = kp();
            $cr = JkdMaster::create($data);
        }else{
            $cr = JkdMaster::where('id', request('id'))->update($data);
        }


        if ($cr) {
            return redirect(route('master.jamKerjaDinamis.jkdMaster.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jamKerjaDinamis.jkdMaster.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function json()
    {
        $jkdMaster = JkdMaster::orderBy('nama')->get();
        SelectJkdMaster::withoutWrapping();
        $jkdMaster = SelectJkdMaster::collection($jkdMaster);

        return response()->json($jkdMaster);
    }
}
