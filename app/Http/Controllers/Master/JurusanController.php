<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JurusanResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Jurusan;

class JurusanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $jurusan = Jurusan::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->paginate($limit);

        $jurusan->appends(request()->all());

        $jurusan = JurusanResource::collection($jurusan);

        return inertia('Master/Jurusan/Index', compact('jurusan'));
    }

    public function json($pendidikan = null)
    {
        $jurusan = Jurusan::orderBy('nama')
                        ->when($pendidikan, function($qr, $pendidikan){
                            $qr->where('kode_pendidikan', $pendidikan);
                        })
                        ->get();
        SelectResource::withoutWrapping();
        $jurusan = SelectResource::collection($jurusan);

        return response()->json($jurusan);
    }

    public function add()
    {
        $jurusan = new Jurusan();
        return inertia('Master/Jurusan/Add', compact('jurusan'));
    }

    public function edit(Jurusan $jurusan)
    {
        return inertia('Master/Jurusan/Add', compact('jurusan'));
    }

    public function delete(Jurusan $jurusan)
    {
        $cr = $jurusan->delete();
        if ($cr) {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_jurusan' => 'required',
            'kode_pendidikan' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_jurusan'] = 'required|unique:jurusan';
        }

        $data = request()->validate($rules);

        $cr = Jurusan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
