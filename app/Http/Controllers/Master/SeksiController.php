<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\SeksiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Seksi;

class SeksiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $seksi = Seksi::when($search, function($qr, $search){
                        $qr->where('nama', 'LIKE', "%$search%")
                        ->orWhere('singkatan', 'LIKE', "%$search%")
                        ->orWhereRelation('atasan', 'nama', "%$search%");
                    })
                    ->paginate($limit);
        $seksi->appends(request()->all());

        $seksi = SeksiResource::collection($seksi);

        return inertia('Master/Seksi/Index', compact('seksi'));
    }

    public function json($bidang)
    {
        $seksi = Seksi::orderBy('nama')->where('kode_bidang', $bidang)->get();
        SelectResource::withoutWrapping();
        $seksi = SelectResource::collection($seksi);

        return response()->json($seksi);
    }

    public function bawahan()
    {
        $seksi = request('seksi');

        $seksi = Seksi::orderBy('nama')->where('kode_atasan', $seksi)->get();
        SelectResource::withoutWrapping();
        $seksi = SelectResource::collection($seksi);

        return response()->json($seksi);
    }

    public function add()
    {
        $seksi = new Seksi();

        return inertia('Master/Seksi/Add', compact('seksi'));
    }

    public function edit(Seksi $seksi)
    {
        return inertia('Master/Seksi/Add', compact('seksi'));
    }

    public function delete(Seksi $seksi)
    {
        $cr = $seksi->delete();
        if ($cr) {
            return redirect(route('master.seksi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.seksi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_seksi' => 'required',
            'kode_bidang' => 'required',
            'kode_skpd' => 'required',
            'nama' => 'required',
            'singkatan' => 'required',
        ];

        if(!request('id')){
            $rules['kode_seksi'] = 'required|unique:seksi';
        }

        $data = request()->validate($rules);

        $cr = Seksi::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.seksi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.seksi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
