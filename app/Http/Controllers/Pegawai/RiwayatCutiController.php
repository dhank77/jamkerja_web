<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatCutiResource;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\RiwayatCuti;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatCutiController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rcuti = DataPengajuanCuti::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_mulai')
                        ->where('status', 1)
                        ->paginate($limit);

        $Rcuti->appends(request()->all());
        $Rcuti = RiwayatCutiResource::collection($Rcuti);
        return inertia('Pegawai/Cuti/Index', compact('pegawai', 'Rcuti'));
    }

    public function add(User $pegawai)
    {
        $Rcuti = new DataPengajuanCuti();
        return inertia('Pegawai/Cuti/Add', compact('pegawai', 'Rcuti'));
    }

    public function edit(User $pegawai, DataPengajuanCuti $Rcuti)
    {
        return inertia('Pegawai/Cuti/Add', compact('pegawai', 'Rcuti'));
    }

    public function delete(User $pegawai, DataPengajuanCuti $Rcuti)
    {
        $cr = $Rcuti->delete();
        if ($cr) {
            return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_cuti' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['status'] = 1;

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = DataPengajuanCuti::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-cuti-" . date('ymdhis') . ".pdf");
        }

        if($id){
            $cr = DataPengajuanCuti::where('id', $id)->where('nip', $pegawai->nip)->update($data);
        }else{
            $data['nip'] = $pegawai->nip;
            $data['kode_perusahaan'] = kp();
            $cr = DataPengajuanCuti::create($data);
        }


        if ($cr) {
            return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
