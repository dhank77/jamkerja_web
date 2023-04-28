<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatBahasaResource;
use App\Models\Pegawai\RiwayatBahasa;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatBahasaController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rbahasa = RiwayatBahasa::where('nip', $pegawai->nip)
                        ->paginate($limit);

        $Rbahasa->appends(request()->all());
        $Rbahasa = RiwayatBahasaResource::collection($Rbahasa);
        return inertia('Pegawai/Bahasa/Index', compact('pegawai', 'Rbahasa'));
    }

    public function add(User $pegawai)
    {
        $Rbahasa = new RiwayatBahasa();
        return inertia('Pegawai/Bahasa/Add', compact('pegawai', 'Rbahasa'));
    }

    public function edit(User $pegawai, RiwayatBahasa $Rbahasa)
    {
        return inertia('Pegawai/Bahasa/Add', compact('pegawai', 'Rbahasa'));
    }

    public function delete(User $pegawai, RiwayatBahasa $Rbahasa)
    {
        $cr = $Rbahasa->delete();
        if ($cr) {
            return redirect(route('pegawai.bahasa.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.bahasa.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nama_bahasa' => 'required',
            'penguasaan' => 'required',
            'jenis' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatBahasa::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
            Storage::delete($file);
        }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-bahasa-" . request('no_sertifikat') . ".pdf");
        }

        $cr = RiwayatBahasa::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.bahasa.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.bahasa.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
