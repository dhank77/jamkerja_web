<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\HariLiburResource;
use App\Models\Master\HariLibur;

class HariLiburController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $hariLibur = HariLibur::when($search, function($qr, $search){
                                    $qr->where('nama', 'LIKE', "%$search%");
                                })
                                ->where('kode_perusahaan', kp())
                                ->paginate($limit);

        $hariLibur->appends(request()->all());

        $hariLibur = HariLiburResource::collection($hariLibur);

        return inertia('Master/HariLibur/Index', compact('hariLibur'));
    }

    public function add()
    {
        $hariLibur = new HariLibur();
        return inertia('Master/HariLibur/Add', compact('hariLibur'));
    }

    public function edit(HariLibur $hariLibur)
    {
        return inertia('Master/HariLibur/Add', compact('hariLibur'));
    }

    public function delete(HariLibur $hariLibur)
    {
        $cr = $hariLibur->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'nama' => 'required',
        ];

        $data = request()->validate($rules);

        if(strtotime(request('tanggal_mulai')) > strtotime(request('tanggal_selesai'))){
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => "Gagal, Tanggal mulai harus lebih kecil dari tanggal selesai!"
            ]);
        }

        if(request('id')){
            $cr = HariLibur::where('id', request('id'))->update($data);
        }else{
            $data['kode_perusahaan'] = kp();
            $cr = HariLibur::create($data);
        }


        if ($cr) {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
