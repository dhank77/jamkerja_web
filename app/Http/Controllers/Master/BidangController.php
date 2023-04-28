<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\BidangResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Bidang;

class BidangController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $bidang = Bidang::when($search, function($qr, $search){
                        $qr->where('nama', 'LIKE', "%$search%");
                    })
                    ->paginate($limit);

        $bidang->appends(request()->all());

        $bidang = BidangResource::collection($bidang);

        return inertia('Master/Bidang/Index', compact('bidang'));
    }

    public function json($skpd)
    {
        $bidang = Bidang::orderBy('nama')->where('kode_skpd', $skpd)->get();
        SelectResource::withoutWrapping();
        $bidang = SelectResource::collection($bidang);

        return response()->json($bidang);
    }

    public function add()
    {
        $bidang = new Bidang();
        return inertia('Master/Bidang/Add', compact('bidang'));
    }

    public function edit(Bidang $bidang)
    {
        return inertia('Master/Bidang/Add', compact('bidang'));
    }

    public function delete(Bidang $bidang)
    {
        $cr = $bidang->delete();
        if ($cr) {
            return redirect(route('master.bidang.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.bidang.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_bidang' => 'required',
            'kode_skpd' => 'required',
            'nama' => 'required',
            'singkatan' => 'nullable',
        ];

        if(!request('id')){
            $rules['kode_bidang'] = 'required|unique:bidang';
        }

        $data = request()->validate($rules);

        $cr = Bidang::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.bidang.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.bidang.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
