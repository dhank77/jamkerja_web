<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\KursusResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Kursus;

class KursusController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $kursus = Kursus::when($search, function($qr, $search){
                        $qr->where('nama', 'LIKE', "%$search%");
                    })
                    ->paginate($limit);

        $kursus->appends(request()->all());

        $kursus = KursusResource::collection($kursus);

        return inertia('Master/Kursus/Index', compact('kursus'));
    }

    public function json()
    {
        $kursus = Kursus::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $kursus = SelectResource::collection($kursus);

        return response()->json($kursus);
    }

    public function add()
    {
        $kursus = new Kursus();
        return inertia('Master/Kursus/Add', compact('kursus'));
    }

    public function edit(Kursus $kursus)
    {
        return inertia('Master/Kursus/Add', compact('kursus'));
    }

    public function delete(Kursus $kursus)
    {
        $cr = $kursus->delete();
        if ($cr) {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_kursus' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_kursus'] = 'required|unique:kursus';
        }

        $data = request()->validate($rules);

        $cr = Kursus::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
