<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatOrganisasiResource;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatOrganisasiController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rorganisasi = RiwayatOrganisasi::where('nip', $pegawai->nip)
                        ->orderByDesc('tanggal_mulai')
                        ->paginate($limit);

        $Rorganisasi->appends(request()->all());
        $Rorganisasi = RiwayatOrganisasiResource::collection($Rorganisasi);
        return inertia('Pegawai/Organisasi/Index', compact('pegawai', 'Rorganisasi'));
    }

    public function add(User $pegawai)
    {
        $Rorganisasi = new RiwayatOrganisasi();
        return inertia('Pegawai/Organisasi/Add', compact('pegawai', 'Rorganisasi'));
    }

    public function edit(User $pegawai, RiwayatOrganisasi $Rorganisasi)
    {
        return inertia('Pegawai/Organisasi/Add', compact('pegawai', 'Rorganisasi'));
    }

    public function delete(User $pegawai, RiwayatOrganisasi $Rorganisasi)
    {
        $cr = $Rorganisasi->delete();
        if ($cr) {
            return redirect(route('pegawai.organisasi.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.organisasi.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nama_organisasi' => 'required',
            'jenis_organisasi' => 'required',
            'jabatan' => 'nullable',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
            'nama_pimpinan' => 'nullable',
            'tempat' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatOrganisasi::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
            Storage::delete($file);
        }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-organisasi-" . request('no_sertifikat') . ".pdf");
        }

        $cr = RiwayatOrganisasi::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.organisasi.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.organisasi.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
