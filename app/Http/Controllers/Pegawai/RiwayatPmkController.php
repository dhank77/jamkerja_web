<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPmkResource;
use App\Models\Pegawai\RiwayatPmk;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatPmkController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rpmk = RiwayatPmk::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_sk')
                        ->paginate($limit);

        $Rpmk->appends(request()->all());
        $Rpmk = RiwayatPmkResource::collection($Rpmk);
        return inertia('Pegawai/Pmk/Index', compact('pegawai', 'Rpmk'));
    }

    public function add(User $pegawai)
    {
        $Rpmk = new RiwayatPmk();
        return inertia('Pegawai/Pmk/Add', compact('pegawai', 'Rpmk'));
    }

    public function edit(User $pegawai, RiwayatPmk $Rpmk)
    {
        return inertia('Pegawai/Pmk/Add', compact('pegawai', 'Rpmk'));
    }

    public function delete(User $pegawai, RiwayatPmk $Rpmk)
    {
        $cr = $Rpmk->delete();
        if ($cr) {
            return redirect(route('pegawai.pmk.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.pmk.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'jenis_pmk' => 'required',
            'instansi' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            // 'nomor_sk' => 'required',
            // 'tanggal_sk' => 'required',
            'masa_kerja_bulan' => 'required',
            'masa_kerja_tahun' => 'required',
            'nomor_bkn' => 'nullable',
            'tanggal_bkn' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatPmk::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-pmk-" . date("ymdhis") . ".pdf");
        }

        if($id){
            $cr = RiwayatPmk::where('id', $id)->where('nip', $pegawai->nip)->update($data);
        }else{
            $data['nip'] = $pegawai->nip;
            $data['kode_perusahaan'] = kp();
            $cr = RiwayatPmk::create($data);
        }

        if ($cr) {
            return redirect(route('pegawai.pmk.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.pmk.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
