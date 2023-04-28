<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatLhkpnResource;
use App\Models\Pegawai\RiwayatLhkpn;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatLhkpnController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rlhkpn = RiwayatLhkpn::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_pelaporan')
                        ->paginate($limit);

        $Rlhkpn->appends(request()->all());
        $Rlhkpn = RiwayatLhkpnResource::collection($Rlhkpn);
        return inertia('Pegawai/Lhkpn/Index', compact('pegawai', 'Rlhkpn'));
    }

    public function add(User $pegawai)
    {
        $Rlhkpn = new RiwayatLhkpn();
        return inertia('Pegawai/Lhkpn/Add', compact('pegawai', 'Rlhkpn'));
    }

    public function edit(User $pegawai, RiwayatLhkpn $Rlhkpn)
    {
        return inertia('Pegawai/Lhkpn/Add', compact('pegawai', 'Rlhkpn'));
    }

    public function delete(User $pegawai, RiwayatLhkpn $Rlhkpn)
    {
        $cr = $Rlhkpn->delete();
        if ($cr) {
            return redirect(route('pegawai.lhkpn.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.lhkpn.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'tanggal_pelaporan' => 'required',
            'jenis_form' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatLhkpn::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
            Storage::delete($file);
        }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-lhkpn-" . request('tanggal_pelaporan') . ".pdf");
        }

        $cr = RiwayatLhkpn::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.lhkpn.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.lhkpn.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
