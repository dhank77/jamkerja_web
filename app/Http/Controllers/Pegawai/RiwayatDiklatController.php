<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatDiklatResource;
use App\Models\Pegawai\RiwayatDiklat;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatDiklatController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rdiklat = RiwayatDiklat::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_mulai')
                        ->paginate($limit);

        $Rdiklat->appends(request()->all());
        $Rdiklat = RiwayatDiklatResource::collection($Rdiklat);
        return inertia('Pegawai/Diklat/Index', compact('pegawai', 'Rdiklat'));
    }

    public function add(User $pegawai)
    {
        $Rdiklat = new RiwayatDiklat();
        return inertia('Pegawai/Diklat/Add', compact('pegawai', 'Rdiklat'));
    }

    public function edit(User $pegawai, RiwayatDiklat $Rdiklat)
    {
        return inertia('Pegawai/Diklat/Add', compact('pegawai', 'Rdiklat'));
    }

    public function delete(User $pegawai, RiwayatDiklat $Rdiklat)
    {
        $cr = $Rdiklat->delete();
        if ($cr) {
            return redirect(route('pegawai.diklat.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.diklat.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_diklat_struktural' => 'required',
            'tempat' => 'required',
            'pelaksana' => 'required',
            'angkatan' => 'required',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
            'jumlah_jp' => 'nullable',
            'no_sertifikat' => 'required',
            'tanggal_sertifikat' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatDiklat::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-diklat-struktural-" . date("ymdhis") . ".pdf");
        }

        $cr = RiwayatDiklat::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.diklat.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.diklat.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
