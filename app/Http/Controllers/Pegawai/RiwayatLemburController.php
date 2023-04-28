<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatLemburResource;
use App\Http\Resources\Pengajuan\LemburPengajuanResource;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatLemburController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rlembur = DataPengajuanLembur::where('nip', $pegawai->nip)
                                ->orderByDesc('tanggal')
                                ->paginate($limit);

        $Rlembur->appends(request()->all());
        $Rlembur = LemburPengajuanResource::collection($Rlembur);
        return inertia('Pegawai/Lembur/Index', compact('pegawai', 'Rlembur'));
    }

    public function add(User $pegawai)
    {
        $Rlembur = new DataPengajuanLembur();
        return inertia('Pegawai/Lembur/Add', compact('pegawai', 'Rlembur'));
    }

    public function edit(User $pegawai, DataPengajuanLembur $Rlembur)
    {
        return inertia('Pegawai/Lembur/Add', compact('pegawai', 'Rlembur'));
    }

    public function delete(User $pegawai, DataPengajuanLembur $Rlembur)
    {
        tambah_log($pegawai->nip, "App\Models\Pegawai\DataPengajuanLembur", $Rlembur->id, 'dihapus');
        $cr = $Rlembur->delete();
        if ($cr) {
            return redirect(route('pegawai.lembur.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.lembur.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nomor_surat' => 'required',
            'tanggal_surat' => 'nullable',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = DataPengajuanLembur::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Models\Pegawai\DataPengajuanLembur", $id, 'diubah');
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-lembur-" . request('nomor_surat') . ".pdf");
        }

        $cr = DataPengajuanLembur::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        if(!$id){
            tambah_log($pegawai->nip, "App\Models\Pegawai\DataPengajuanLembur", $cr->id, 'ditambahkan');
        }

        if ($cr) {
            return redirect(route('pegawai.lembur.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.lembur.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
