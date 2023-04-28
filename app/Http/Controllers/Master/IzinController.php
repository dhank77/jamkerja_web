<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\IzinResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $izin = Izin::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->paginate($limit);

        $izin->appends(request()->all());

        $izin = IzinResource::collection($izin);

        return inertia('Master/Izin/Index', compact('izin'));
    }

    public function json()
    {
        $izin = Izin::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $izin = SelectResource::collection($izin);

        return response()->json($izin);
    }

    public function add()
    {
        $izin = new Izin();
        return inertia('Master/Izin/Add', compact('izin'));
    }

    public function edit(Izin $izin)
    {
        return inertia('Master/Izin/Add', compact('izin'));
    }

    public function delete(Izin $izin)
    {
        $cr = $izin->delete();
        if ($cr) {
            return redirect(route('master.izin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.izin.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_izin' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_izin'] = 'required|unique:izin';
        }

        $data = request()->validate($rules);

        $cr = izin::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.izin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.izin.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
