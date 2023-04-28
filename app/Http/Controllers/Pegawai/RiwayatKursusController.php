<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatKursusResource;
use App\Models\Pegawai\RiwayatKursus;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatKursusController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rkursus = RiwayatKursus::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_mulai')
                        ->paginate($limit);

        $Rkursus->appends(request()->all());
        $Rkursus = RiwayatKursusResource::collection($Rkursus);
        return inertia('Pegawai/Kursus/Index', compact('pegawai', 'Rkursus'));
    }

    public function add(User $pegawai)
    {
        $Rkursus = new RiwayatKursus();
        return inertia('Pegawai/Kursus/Add', compact('pegawai', 'Rkursus'));
    }

    public function edit(User $pegawai, RiwayatKursus $Rkursus)
    {
        return inertia('Pegawai/Kursus/Add', compact('pegawai', 'Rkursus'));
    }

    public function delete(User $pegawai, RiwayatKursus $Rkursus)
    {
        $cr = $Rkursus->delete();
        if ($cr) {
            return redirect(route('pegawai.kursus.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.kursus.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_kursus' => 'required',
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
                $file = RiwayatKursus::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
            Storage::delete($file);
        }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-kursus-" . request('no_sertifikat') . ".pdf");
        }

        $cr = RiwayatKursus::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.kursus.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.kursus.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
