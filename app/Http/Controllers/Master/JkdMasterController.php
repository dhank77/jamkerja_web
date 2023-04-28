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
            'kode_jkd' => 'required',
            'nama' => 'required',
            'jam_datang' => 'required',
            'jam_pulang' => 'required',
            'istirahat' => 'required',
            'color' => 'required',
            'toleransi_datang' => 'nullable',
            'toleransi_pulang' => 'nullable',
        ];

        if(!request('id')){
            $rules['kode_jkd'] = 'required|unique:jkd_master';
        }

        $data = request()->validate($rules);

        $cr = JkdMaster::updateOrCreate(['id' => request('id')], $data);

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
