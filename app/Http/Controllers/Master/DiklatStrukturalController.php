<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\DiklatStrukturalResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\DiklatStruktural;
use Illuminate\Http\Request;

class DiklatStrukturalController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $diklatStruktural = DiklatStruktural::when($search, function($qr, $search){
                                $qr->where('nama', 'LIKE', "%$search%");
                            })
                            ->paginate($limit);

        $diklatStruktural->appends(request()->all());

        $diklatStruktural = DiklatStrukturalResource::collection($diklatStruktural);

        return inertia('Master/DiklatStruktural/Index', compact('diklatStruktural'));
    }

    public function json()
    {
        $diklatStruktural = DiklatStruktural::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $diklatStruktural = SelectResource::collection($diklatStruktural);

        return response()->json($diklatStruktural);
    }

    public function add()
    {
        $diklatStruktural = new DiklatStruktural();
        return inertia('Master/DiklatStruktural/Add', compact('diklatStruktural'));
    }

    public function edit(DiklatStruktural $diklatStruktural)
    {
        return inertia('Master/DiklatStruktural/Add', compact('diklatStruktural'));
    }

    public function delete(DiklatStruktural $diklatStruktural)
    {
        $cr = $diklatStruktural->delete();
        if ($cr) {
            return redirect(route('master.diklatStruktural.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.diklatStruktural.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_diklat_struktural' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_diklat_struktural'] = 'required|unique:diklat_struktural';
        }

        $data = request()->validate($rules);

        $cr = DiklatStruktural::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.diklatStruktural.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.diklatStruktural.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
