<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\ReimbursementPengajuanResource;
use App\Models\Pegawai\DataPengajuanReimbursement;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatReimbursementController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rreimbursement = DataPengajuanReimbursement::where('nip', $pegawai->nip)
                                ->orderByDesc('tanggal_surat')
                                ->paginate($limit);

        $Rreimbursement->appends(request()->all());
        $Rreimbursement = ReimbursementPengajuanResource::collection($Rreimbursement);
        return inertia('Pegawai/Reimbursement/Index', compact('pegawai', 'Rreimbursement'));
    }

    public function add(User $pegawai)
    {
        $Rreimbursement = new DataPengajuanReimbursement();
        return inertia('Pegawai/Reimbursement/Add', compact('pegawai', 'Rreimbursement'));
    }

    public function edit(User $pegawai, DataPengajuanReimbursement $Rreimbursement)
    {
        return inertia('Pegawai/Reimbursement/Add', compact('pegawai', 'Rreimbursement'));
    }

    public function delete(User $pegawai, DataPengajuanReimbursement $Rreimbursement)
    {
        tambah_log($pegawai->nip, "App\Models\Pegawai\DataPengajuanReimbursement", $Rreimbursement->id, 'dihapus');
        $cr = $Rreimbursement->delete();
        if ($cr) {
            return redirect(route('pegawai.reimbursement.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.reimbursement.index', $pegawai->nip))->with([
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
            'nilai' => 'required',
            'kode_reimbursement' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['nilai'] = number_to_sql($data['nilai']);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = DataPengajuanReimbursement::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Models\Pegawai\DataPengajuanReimbursement", $id, 'diubah');
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-reimbursement-" . date('ymdhis') . ".pdf");
        }

        $cr = DataPengajuanReimbursement::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        if(!$id){
            tambah_log($pegawai->nip, "App\Models\Pegawai\DataPengajuanReimbursement", $cr->id, 'ditambahkan');
        }

        if ($cr) {
            return redirect(route('pegawai.reimbursement.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.reimbursement.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
