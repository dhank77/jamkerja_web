<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\LainnyaResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Lainnya;

class LainnyaController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $lainnya = Lainnya::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->where('kode_perusahaan', kp())
                ->paginate($limit);

        $lainnya->appends(request()->all());

        $lainnya = LainnyaResource::collection($lainnya);

        return inertia('Master/Lainnya/Index', compact('lainnya'));
    }

    public function json()
    {
        $lainnya = Lainnya::orderBy('nama')->where('kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $lainnya = SelectResource::collection($lainnya);

        return response()->json($lainnya);
    }

    public function add()
    {
        $lainnya = new Lainnya();
        return inertia('Master/Lainnya/Add', compact('lainnya'));
    }

    public function edit(Lainnya $lainnya)
    {
        return inertia('Master/Lainnya/Add', compact('lainnya'));
    }

    public function delete(Lainnya $lainnya)
    {
        $cr = $lainnya->delete();
        if ($cr) {
            return redirect(route('master.lainnya.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.lainnya.index'))->with([
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
            $cr = Lainnya::where('id', request('id'))->update($data);
        }else{
            $data['kode_lainnya'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Lainnya::create($data);
        }


        if ($cr) {
            return redirect(route('master.lainnya.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.lainnya.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
