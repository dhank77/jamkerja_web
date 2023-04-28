<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPendidikanResource;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatPendidikanController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rpendidikan = RiwayatPendidikan::where('nip', $pegawai->nip)
                        ->orderByDesc('kode_pendidikan')
                        ->paginate($limit);

        $Rpendidikan->appends(request()->all());
        $Rpendidikan = RiwayatPendidikanResource::collection($Rpendidikan);
        return inertia('Pegawai/Pendidikan/Index', compact('pegawai', 'Rpendidikan'));
    }

    public function add(User $pegawai)
    {
        $Rpendidikan = new RiwayatPendidikan();
        return inertia('Pegawai/Pendidikan/Add', compact('pegawai', 'Rpendidikan'));
    }

    public function edit(User $pegawai, RiwayatPendidikan $Rpendidikan)
    {
        return inertia('Pegawai/Pendidikan/Add', compact('pegawai', 'Rpendidikan'));
    }

    public function delete(User $pegawai, RiwayatPendidikan $Rpendidikan)
    {
        $cr = $Rpendidikan->delete();
        if ($cr) {
            return redirect(route('pegawai.pendidikan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.pendidikan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, Riwayatpendidikan $Rpendidikan)
    {
        if($Rpendidikan->file){
            Storage::delete($Rpendidikan->file);
        }
        RiwayatPendidikan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $Rpendidikan->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.pendidikan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.pendidikan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_pendidikan' => 'required',
            'kode_jurusan' => 'nullable',
            'nomor_ijazah' => 'required',
            'nama_sekolah' => 'required',
            'tanggal_lulus' => 'required',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'is_akhir' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        if (request('is_akhir') == 1) {
            RiwayatPendidikan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if($id){
            if(request()->file('file')){
                $file = RiwayatPendidikan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if($file){
            Storage::delete($file);
        }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-pendidikan-" . request('nomor_ijazah') . request('kode_pendidikan') . ".pdf");
        }

        $cr = RiwayatPendidikan::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.pendidikan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.pendidikan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
