<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\SkpdResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Skpd;

class SkpdController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $skpd = Skpd::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%")
                    ->orWhere('singkatan', 'LIKE', "%$search%")
                    ->orWhereRelation('atasan', 'nama', "%$search%");
                })
                ->where('kode_perusahaan', auth()->user()->kode_perusahaan)
                ->paginate($limit);
        $skpd->appends(request()->all());

        $skpd = SkpdResource::collection($skpd);

        return inertia('Master/Skpd/Index', compact('skpd'));
    }

    public function json()
    {
        $skpd = Skpd::orderBy('nama')->where('kode_perusahaan', auth()->user()->kode_perusahaan)->get();
        SelectResource::withoutWrapping();
        $skpd = SelectResource::collection($skpd);

        return response()->json($skpd);
    }

    public function bawahan()
    {
        $skpd = request('skpd');

        $skpd = Skpd::orderBy('nama')->where('kode_perusahaan', auth()->user()->kode_perusahaan)->where('kode_atasan', $skpd)->get();
        SelectResource::withoutWrapping();
        $skpd = SelectResource::collection($skpd);

        return response()->json($skpd);
    }

    public function add()
    {
        $skpd = new Skpd();

        return inertia('Master/Skpd/Add', compact('skpd'));
    }

    public function edit(Skpd $skpd)
    {
        return inertia('Master/Skpd/Add', compact('skpd'));
    }

    public function reset(Skpd $skpd)
    {
        $cr = $skpd->where('kode_perusahaan', auth()->user()->kode_perusahaan)->update([
            'kordinat' => null,
            'latitude' => null,
            'longitude' => null,
            'jarak' => 0,
        ]);
        if ($cr) {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, direset!"
            ]);
        } else {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, direset!"
            ]);
        }
    }

    public function delete(Skpd $skpd)
    {
        $cr = $skpd->where('kode_perusahaan', auth()->user()->kode_perusahaan)->delete();
        if ($cr) {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'singkatan' => 'required',
            'kordinat' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'jarak' => 'nullable',
        ];
        
        $data = request()->validate($rules);

        if(!request('id')){
            $data['kode_skpd'] = generateUUID();
            $data['kode_perusahaan'] = kp();
        }

        $cr = Skpd::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
