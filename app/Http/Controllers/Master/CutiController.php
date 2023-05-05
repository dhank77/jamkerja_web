<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\CutiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Cuti;

class CutiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $cuti = Cuti::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->where(function ($qr) {
                $qr->where('kode_perusahaan', kp())
                    ->orWhereNull('kode_perusahaan');
            })
            ->paginate($limit);

        $cuti->appends(request()->all());

        $cuti = CutiResource::collection($cuti);

        return inertia('Master/Cuti/Index', compact('cuti'));
    }

    public function json()
    {
        $cuti = Cuti::orderBy('nama')->where(function ($qr) {
            $qr->where('kode_perusahaan', kp())
                ->orWhereNull('kode_perusahaan');
        })->get();
        SelectResource::withoutWrapping();
        $cuti = SelectResource::collection($cuti);

        return response()->json($cuti);
    }

    public function add()
    {
        $cuti = new Cuti();
        return inertia('Master/Cuti/Add', compact('cuti'));
    }

    public function edit(Cuti $cuti)
    {
        return inertia('Master/Cuti/Add', compact('cuti'));
    }

    public function delete(Cuti $cuti)
    {
        $cr = $cuti->where(function ($qr) {
            $qr->where('kode_perusahaan', kp())
                ->orWhereNull('kode_perusahaan');
        })->delete();
        if ($cr) {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'hari' => 'required',
        ];

        $data = request()->validate($rules);

        if (!request('id')) {
            $data['kode_cuti'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Cuti::create($data);
        } else {
            $cr = Cuti::where('id', request('id'))->update($data);
        }


        if ($cr) {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
