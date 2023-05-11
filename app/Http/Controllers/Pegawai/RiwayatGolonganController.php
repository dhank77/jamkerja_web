<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatGolonganResource;
use App\Models\Pegawai\RiwayatGolongan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatGolonganController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rgolongan = RiwayatGolongan::where('nip', $pegawai->nip)
                    ->orderByDesc('tanggal_tmt')
                    ->paginate($limit);

        $Rgolongan->appends(request()->all());
        $Rgolongan = RiwayatGolonganResource::collection($Rgolongan);
        return inertia('Pegawai/Golongan/Index', compact('pegawai', 'Rgolongan'));
    }

    public function add(User $pegawai)
    {
        $Rgolongan = new RiwayatGolongan();
        return inertia('Pegawai/Golongan/Add', compact('pegawai', 'Rgolongan'));
    }

    public function edit(User $pegawai, RiwayatGolongan $Rgolongan)
    {
        return inertia('Pegawai/Golongan/Add', compact('pegawai', 'Rgolongan'));
    }

    public function delete(User $pegawai, RiwayatGolongan $Rgolongan)
    {
        $cr = $Rgolongan->delete();
        if ($cr) {
            return redirect(route('pegawai.golongan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.golongan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, RiwayatGolongan $Rgolongan)
    {
        if($Rgolongan->file){
            Storage::delete($Rgolongan->file);
        }
        RiwayatGolongan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);

        $cr = $Rgolongan->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.golongan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.golongan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_golongan' => 'required',
            'kode_kp' => 'required',
            'no_sk' => 'required|unique:riwayat_golongan',
            'tanggal_sk' => 'required',
            'tanggal_tmt' => 'required',
            'sk_bkn' => 'nullable',
            'tanggal_bkn' => 'nullable',
            'masa_bulan' => 'nullable',
            'masa_tahun' => 'nullable',
            'is_akhir' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        if (request('is_akhir') == 1) {
            RiwayatGolongan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatGolongan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-golongan-" . date("ymdhis") . ".pdf");
        }

        $cr = RiwayatGolongan::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.golongan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.golongan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
