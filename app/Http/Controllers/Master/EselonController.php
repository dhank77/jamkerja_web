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
                ->where('kode_perusahaan', auth()->user()->kode_perusahaan)
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
        $eselon = Eselon::orderBy('nama')->where('kode_perusahaan', auth()->user()->kode_perusahaan)->get();
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
        $cr = $eselon->where('kode_perusahaan', auth()->user()->kode_perusahaan)->update([
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
        $cr = $eselon->where('kode_perusahaan', auth()->user()->kode_perusahaan)->delete();
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
            'nama' => 'required',
            'kordinat' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'jarak' => 'nullable',
        ];

        $data = request()->validate($rules);
        
        if(!request('id')){
            $data['kode_eselon'] = generateUUID();
            $data['kode_perusahaan'] = kp();
        }
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
