<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatLhkasnResource;
use App\Models\Pegawai\RiwayatLhkasn;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatLhkasnController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rlhkasn = RiwayatLhkasn::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_pelaporan')
                        ->paginate($limit);

        $Rlhkasn->appends(request()->all());
        $Rlhkasn = RiwayatLhkasnResource::collection($Rlhkasn);
        return inertia('Pegawai/Lhkasn/Index', compact('pegawai', 'Rlhkasn'));
    }

    public function add(User $pegawai)
    {
        $Rlhkasn = new RiwayatLhkasn();
        return inertia('Pegawai/Lhkasn/Add', compact('pegawai', 'Rlhkasn'));
    }

    public function edit(User $pegawai, RiwayatLhkasn $Rlhkasn)
    {
        return inertia('Pegawai/Lhkasn/Add', compact('pegawai', 'Rlhkasn'));
    }

    public function delete(User $pegawai, RiwayatLhkasn $Rlhkasn)
    {
        $cr = $Rlhkasn->delete();
        if ($cr) {
            return redirect(route('pegawai.lhkasn.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.lhkasn.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'tanggal_pelaporan' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatLhkasn::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-lhkasn-" . date("ymdhis") . ".pdf");
        }

        $cr = RiwayatLhkasn::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.lhkasn.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.lhkasn.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
