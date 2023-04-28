<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\StatusPegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\StatusPegawai;

class StatusPegawaiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $status_pegawai = StatusPegawai::when($search, function($qr, $search){
                    $qr->where('nama', 'LIKE', "%$search%");
                })
                ->paginate($limit);

        $status_pegawai->appends(request()->all());

        $status_pegawai = StatusPegawaiResource::collection($status_pegawai);

        return inertia('Master/StatusPegawai/Index', compact('status_pegawai'));
    }

    public function json()
    {
        $status_pegawai = StatusPegawai::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $status_pegawai = SelectResource::collection($status_pegawai);

        return response()->json($status_pegawai);
    }

    public function add()
    {
        $status_pegawai = new StatusPegawai();
        return inertia('Master/StatusPegawai/Add', compact('status_pegawai'));
    }

    public function edit(StatusPegawai $status_pegawai)
    {
        return inertia('Master/StatusPegawai/Add', compact('status_pegawai'));
    }

    public function delete(StatusPegawai $status_pegawai)
    {
        $cr = $status_pegawai->delete();
        if ($cr) {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_status' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_status'] = 'required|unique:status_pegawai';
        }

        $data = request()->validate($rules);

        $cr = StatusPegawai::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
