<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PenghargaanResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Penghargaan;

class PenghargaanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $penghargaan = Penghargaan::when($search, function($qr, $search){
                        $qr->where('nama', 'LIKE', "%$search%");
                    })
                    ->where('kode_perusahaan', kp())
                    ->paginate($limit);

        $penghargaan->appends(request()->all());

        $penghargaan = PenghargaanResource::collection($penghargaan);

        return inertia('Master/Penghargaan/Index', compact('penghargaan'));
    }

    public function json()
    {
        $penghargaan = Penghargaan::orderBy('nama')->where('kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $penghargaan = SelectResource::collection($penghargaan);

        return response()->json($penghargaan);
    }

    public function add()
    {
        $penghargaan = new Penghargaan();
        return inertia('Master/Penghargaan/Add', compact('penghargaan'));
    }

    public function edit(Penghargaan $penghargaan)
    {
        return inertia('Master/Penghargaan/Add', compact('penghargaan'));
    }

    public function delete(Penghargaan $penghargaan)
    {
        $cr = $penghargaan->delete();
        if ($cr) {
            return redirect(route('master.penghargaan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.penghargaan.index'))->with([
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

        if(request('id')){
            $cr = Penghargaan::where('id', request('id'))->update($data);
        }else{
            $data['kode_penghargaan'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Penghargaan::create($data);
        }

        if ($cr) {
            return redirect(route('master.penghargaan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.penghargaan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
