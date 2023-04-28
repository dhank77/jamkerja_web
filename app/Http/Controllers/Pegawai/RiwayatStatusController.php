<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatStatusResource;
use App\Models\Pegawai\RiwayatStatus;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatStatusController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rstatus = RiwayatStatus::where('nip', $pegawai->nip)
                    ->orderByDesc('tanggal_tmt')
                    ->paginate($limit);

        $Rstatus->appends(request()->all());
        $Rstatus = RiwayatStatusResource::collection($Rstatus);
        return inertia('Pegawai/Status/Index', compact('pegawai', 'Rstatus'));
    }

    public function add(User $pegawai)
    {
        $Rstatus = new RiwayatStatus();
        return inertia('Pegawai/Status/Add', compact('pegawai', 'Rstatus'));
    }

    public function edit(User $pegawai, RiwayatStatus $Rstatus)
    {
        return inertia('Pegawai/Status/Add', compact('pegawai', 'Rstatus'));
    }

    public function delete(User $pegawai, RiwayatStatus $Rstatus)
    {
        if($Rstatus->file){
            Storage::delete($Rstatus->file);
        }
        $cr = $Rstatus->delete();
        if ($cr) {
            return redirect(route('pegawai.status.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.status.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, RiwayatStatus $Rstatus)
    {
        RiwayatStatus::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $Rstatus->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.status.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.status.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'no_sk' => 'required|unique:riwayat_status',
            'kode_golongan' => 'required',
            'kode_status' => 'required',
            'tanggal_sk' => 'required',
            'tanggal_tmt' => 'required',
            'is_akhir' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        if (request('is_akhir') == 1) {
            RiwayatStatus::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatStatus::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
            Storage::delete($file);
        }
            }
        }
        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-status-" . request('no_sk') . ".pdf");
        }

        $cr = RiwayatStatus::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.status.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.status.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
