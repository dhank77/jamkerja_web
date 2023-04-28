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
                    ->paginate($limit);

        $penghargaan->appends(request()->all());

        $penghargaan = PenghargaanResource::collection($penghargaan);

        return inertia('Master/Penghargaan/Index', compact('penghargaan'));
    }

    public function json()
    {
        $penghargaan = Penghargaan::orderBy('nama')->get();
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
            'kode_penghargaan' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_penghargaan'] = 'required|unique:penghargaan';
        }

        $data = request()->validate($rules);

        $cr = Penghargaan::updateOrCreate(['id' => request('id')], $data);

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
