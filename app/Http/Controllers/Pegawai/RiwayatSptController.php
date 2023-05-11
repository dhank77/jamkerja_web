<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatSptResource;
use App\Models\Pegawai\RiwayatSpt;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatSptController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rspt = RiwayatSpt::where('nip', $pegawai->nip)
            ->orderByDesc('tahun')
            ->paginate($limit);

        $Rspt->appends(request()->all());

        $Rspt = RiwayatSptResource::collection($Rspt);
        return inertia('Pegawai/Spt/Index', compact('pegawai', 'Rspt'));
    }

    public function add(User $pegawai)
    {
        $Rspt = new RiwayatSpt();
        return inertia('Pegawai/Spt/Add', compact('pegawai', 'Rspt'));
    }

    public function edit(User $pegawai, RiwayatSpt $Rspt)
    {
        return inertia('Pegawai/Spt/Add', compact('pegawai', 'Rspt'));
    }

    public function delete(User $pegawai, RiwayatSpt $Rspt)
    {
        $cr = $Rspt->delete();
        if ($cr) {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'jenis_spt' => 'required',
            'status_spt' => 'required',
            'nominal' => 'nullable',
            'tanggal_penyampaian' => 'nullable',
            'nomor_tanda_terima_elektronik' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tahun'] = request('tahun') ?? date('Y');

        if (request('nominal')) {
            $data['nominal'] = number_to_sql($data['nominal']);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatSpt::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-spt-" . date("ymdhis") . ".pdf");
        }

        $cr = RiwayatSpt::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        if ($cr) {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
