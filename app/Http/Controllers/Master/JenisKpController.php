<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JenisKpResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\JenisKp;
use Illuminate\Http\Request;

class JenisKpController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $jeniskp = JenisKp::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->paginate($limit);

        $jeniskp->appends(request()->all());

        $jeniskp = JenisKpResource::collection($jeniskp);

        return inertia('Master/JenisKp/Index', compact('jeniskp'));
    }

    public function json()
    {
        $jeniskp = JenisKp::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $jeniskp = SelectResource::collection($jeniskp);

        return response()->json($jeniskp);
    }

    public function add()
    {
        $jeniskp = new JenisKp();
        return inertia('Master/JenisKp/Add', compact('jeniskp'));
    }

    public function edit(JenisKp $jeniskp)
    {
        return inertia('Master/JenisKp/Add', compact('jeniskp'));
    }

    public function delete(JenisKp $jeniskp)
    {
        $cr = $jeniskp->delete();
        if ($cr) {
            return redirect(route('master.jeniskp.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jeniskp.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_kp' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_kp'] = 'required|unique:jenis_kp';
        }

        $data = request()->validate($rules);

        $cr = JenisKp::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.jeniskp.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jeniskp.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
