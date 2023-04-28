<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatKgbResource;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatKgbController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $nOwner = !role('owner');

        $Rkgb = RiwayatKgb::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_surat')
                        ->when($nOwner, function($qr){
                            $qr->where('is_private', 0);
                        })
                        ->paginate($limit);

        $Rkgb->appends(request()->all());
        $Rkgb = RiwayatKgbResource::collection($Rkgb);
        return inertia('Pegawai/Kgb/Index', compact('pegawai', 'Rkgb'));
    }

    public function add(User $pegawai)
    {
        $Rkgb = new RiwayatKgb();
        return inertia('Pegawai/Kgb/Add', compact('pegawai', 'Rkgb'));
    }

    public function edit(User $pegawai, RiwayatKgb $Rkgb)
    {
        return inertia('Pegawai/Kgb/Add', compact('pegawai', 'Rkgb'));
    }

    public function delete(User $pegawai, RiwayatKgb $Rkgb)
    {
        if($Rkgb->file){
            Storage::delete($Rkgb->file);
        }
        $cr = $Rkgb->delete();
        if ($cr) {
            return redirect(route('pegawai.kgb.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.kgb.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, RiwayatKgb $Rkgb)
    {
        RiwayatKgb::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $Rkgb->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required',
            'tanggal_tmt' => 'required',
            'is_akhir' => 'required',
            'is_private' => 'nullable',
            'gaji_pokok' => 'nullable',
            'masa_kerja_tahun' => 'nullable',
            'masa_kerja_bulan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        if (request('is_akhir') == 1) {
            RiwayatKgb::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }
        
        $data = request()->validate($rules);
        if (request('gaji_pokok')) {
            $data['gaji_pokok'] = number_to_sql($data['gaji_pokok']);
        }

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatKgb::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
            Storage::delete($file);
        }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-kgb-" . request('nomor_surat') . ".pdf");
        }

        $cr = RiwayatKgb::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.kgb.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.kgb.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
