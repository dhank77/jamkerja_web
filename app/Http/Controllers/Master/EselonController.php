<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\EselonResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Eselon;

class EselonController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $eselon = Eselon::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->paginate($limit);

        $eselon->appends(request()->all());

        $eselon = EselonResource::collection($eselon);

        return inertia('Master/Eselon/Index', compact('eselon'));
    }

    public function add()
    {
        $eselon = new Eselon();
        return inertia('Master/Eselon/Add', compact('eselon'));
    }

    public function json()
    {
        $eselon = Eselon::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $eselon = SelectResource::collection($eselon);

        return response()->json($eselon);
    }


    public function edit(Eselon $eselon)
    {
        return inertia('Master/Eselon/Add', compact('eselon'));
    }

    public function reset(Eselon $eselon)
    {
        $cr = $eselon->update([
            'kordinat' => null,
            'latitude' => null,
            'longitude' => null,
            'jarak' => 0,
        ]);
        if ($cr) {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, direset!"
            ]);
        } else {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, direset!"
            ]);
        }
    }

    public function delete(Eselon $eselon)
    {
        $cr = $eselon->delete();
        if ($cr) {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_eselon' => 'required',
            'nama' => 'required',
            'kordinat' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'jarak' => 'nullable',
        ];

        if(!request('id')){
            $rules['kode_eselon'] = 'required|unique:eselon';
        }

        $data = request()->validate($rules);

        $cr = Eselon::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
