<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\SukuResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Suku;
use Illuminate\Http\Request;

class SukuController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $suku = Suku::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->paginate($limit);

        $suku->appends(request()->all());

        $suku = SukuResource::collection($suku);

        return inertia('Master/Suku/Index', compact('suku'));
    }

    public function json()
    {
        $suku = Suku::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $suku = SelectResource::collection($suku);

        return response()->json($suku);
    }

    public function add()
    {
        $suku = new Suku();
        return inertia('Master/Suku/Add', compact('suku'));
    }

    public function edit(Suku $suku)
    {
        return inertia('Master/Suku/Add', compact('suku'));
    }

    public function delete(Suku $suku)
    {
        $cr = $suku->delete();
        if ($cr) {
            return redirect(route('master.suku.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.suku.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_suku' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_suku'] = 'required|unique:suku';
        }

        $data = request()->validate($rules);

        $cr = Suku::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.suku.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.suku.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
