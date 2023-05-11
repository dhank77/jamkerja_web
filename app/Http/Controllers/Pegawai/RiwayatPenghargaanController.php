<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPenghargaanResource;
use App\Models\Pegawai\RiwayatPenghargaan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatPenghargaanController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rpenghargaan = RiwayatPenghargaan::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_sk')
                        ->paginate($limit);

        $Rpenghargaan->appends(request()->all());
        $Rpenghargaan = RiwayatPenghargaanResource::collection($Rpenghargaan);
        return inertia('Pegawai/Penghargaan/Index', compact('pegawai', 'Rpenghargaan'));
    }

    public function add(User $pegawai)
    {
        $Rpenghargaan = new RiwayatPenghargaan();
        return inertia('Pegawai/Penghargaan/Add', compact('pegawai', 'Rpenghargaan'));
    }

    public function edit(User $pegawai, RiwayatPenghargaan $Rpenghargaan)
    {
        return inertia('Pegawai/Penghargaan/Add', compact('pegawai', 'Rpenghargaan'));
    }

    public function delete(User $pegawai, RiwayatPenghargaan $Rpenghargaan)
    {
        $cr = $Rpenghargaan->delete();
        if ($cr) {
            return redirect(route('pegawai.penghargaan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.penghargaan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_penghargaan' => 'required',
            'oleh' => 'nullable',
            'nomor_sk' => 'required',
            'tanggal_sk' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatPenghargaan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-penghargaan-" . date("ymdhis") . ".pdf");
        }

        $cr = RiwayatPenghargaan::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.penghargaan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.penghargaan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
