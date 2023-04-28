<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\CutiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Cuti;

class CutiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $cuti = Cuti::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->paginate($limit);

        $cuti->appends(request()->all());

        $cuti = CutiResource::collection($cuti);

        return inertia('Master/Cuti/Index', compact('cuti'));
    }

    public function json()
    {
        $cuti = Cuti::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $cuti = SelectResource::collection($cuti);

        return response()->json($cuti);
    }

    public function add()
    {
        $cuti = new Cuti();
        return inertia('Master/Cuti/Add', compact('cuti'));
    }

    public function edit(Cuti $cuti)
    {
        return inertia('Master/Cuti/Add', compact('cuti'));
    }

    public function delete(Cuti $cuti)
    {
        $cr = $cuti->delete();
        if ($cr) {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_cuti' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_cuti'] = 'required|unique:cuti';
        }

        $data = request()->validate($rules);

        $cr = Cuti::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
