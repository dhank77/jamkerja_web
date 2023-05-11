<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatLainnyaResource;
use App\Models\Pegawai\RiwayatLainnya;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatLainnyaController extends Controller
{

    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rlainnya = RiwayatLainnya::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->paginate($limit);

        $Rlainnya->appends(request()->all());
        $Rlainnya = RiwayatLainnyaResource::collection($Rlainnya);
        return inertia('Pegawai/Lainnya/Index', compact('pegawai', 'Rlainnya'));
    }

    public function add(User $pegawai)
    {
        $Rlainnya = new RiwayatLainnya();
        return inertia('Pegawai/Lainnya/Add', compact('pegawai', 'Rlainnya'));
    }

    public function edit(User $pegawai, RiwayatLainnya $Rlainnya)
    {
        return inertia('Pegawai/Lainnya/Add', compact('pegawai', 'Rlainnya'));
    }

    public function delete(User $pegawai, RiwayatLainnya $Rlainnya)
    {
        $cr = $Rlainnya->delete();
        if ($cr) {
            return redirect(route('pegawai.lainnya.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.lainnya.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_lainnya' => 'required',
            'nomor_sk' => 'required',
            'tanggal_sk' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatLainnya::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }


        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-lainnya-" . date("ymdhis") . ".pdf");
        }

        if($id){
            $cr = RiwayatLainnya::where('id', $id)->where('nip', $pegawai->nip)->update($data);
        }else{
            $data['nip'] = $pegawai->nip;
            $data['kode_perusahaan'] = kp();
            $cr = RiwayatLainnya::create($data);
        }

        if ($cr) {
            return redirect(route('pegawai.lainnya.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.lainnya.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
