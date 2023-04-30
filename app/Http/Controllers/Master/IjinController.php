<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\IjinResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Ijin;

class IjinController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $ijin = Ijin::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->where('kode_perusahaan', kp())
                ->paginate($limit);

        $ijin->appends(request()->all());

        $ijin = IjinResource::collection($ijin);

        return inertia('Master/Ijin/Index', compact('ijin'));
    }

    public function json()
    {
        $ijin = Ijin::orderBy('nama')->where('kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $ijin = SelectResource::collection($ijin);

        return response()->json($ijin);
    }

    public function add()
    {
        $ijin = new Ijin();
        return inertia('Master/Ijin/Add', compact('ijin'));
    }

    public function edit(Ijin $ijin)
    {
        return inertia('Master/Ijin/Add', compact('ijin'));
    }

    public function delete(Ijin $ijin)
    {
        $cr = $ijin->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.ijin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.ijin.index'))->with([
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

        $data = request()->validate($rules);

        if(!request('id')){
            $data['kode_ijin'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Ijin::create($data);
        }else{
            $cr = Ijin::where('id', request('id'))->update($data);
        }

        if ($cr) {
            return redirect(route('master.ijin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.ijin.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
