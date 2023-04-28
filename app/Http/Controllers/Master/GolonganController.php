<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\GolonganResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Golongan;

class GolonganController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $golongan = Golongan::when($search, function($qr, $search){
                        $qr->where('nama', 'LIKE', "%$search%")
                            ->orWhere('pangkat', 'LIKE', "%$search%")
                            ->orWhere('nama_abjad', 'LIKE', "%$search%");
                    })
                    ->paginate($limit);

        $golongan->appends(request()->all());

        $golongan = GolonganResource::collection($golongan);

        return inertia('Master/Golongan/Index', compact('golongan'));
    }

    public function json()
    {
        $golongan = Golongan::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $golongan = SelectResource::collection($golongan);

        return response()->json($golongan);
    }

    public function add()
    {
        $golongan = new Golongan();
        return inertia('Master/Golongan/Add', compact('golongan'));
    }

    public function edit(Golongan $golongan)
    {
        return inertia('Master/Golongan/Add', compact('golongan'));
    }

    public function delete(Golongan $golongan)
    {
        $cr = $golongan->delete();
        if ($cr) {
            return redirect(route('master.golongan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.golongan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_golongan' => 'required',
            'nama' => 'required',
            'pangkat' => 'required',
            'nama_abjad' => 'nullable',
        ];

        if(!request('id')){
            $rules['kode_golongan'] = 'required|unique:golongan';
        }

        $data = request()->validate($rules);

        $cr = Golongan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.golongan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.golongan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
