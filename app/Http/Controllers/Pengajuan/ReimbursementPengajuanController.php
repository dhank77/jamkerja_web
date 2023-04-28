<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\ReimbursementPengajuanResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pegawai\DataPengajuanReimbursement;
use Illuminate\Http\Request;

class ReimbursementPengajuanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = DataPengajuanReimbursement::select('data_pengajuan_reimbursement.*', 'users.name as name')
                                        ->leftJoin('users', 'users.nip', 'data_pengajuan_reimbursement.nip')
                                        ->when($search, function ($qr, $search) {
                                            $qr->where('data_pengajuan_reimbursement.nip', 'LIKE', "%$search%")
                                                ->orWhere('users.name', 'LIKE', "%$search%");
                                        })
                                        ->when($role, function ($qr) {
                                            $skpd = auth()->user()->kepala_divisi_id;
                                                
                                            $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                                    ->where('kode_skpd', $skpd)
                                                    ->where('is_akhir', 1);
                                            });
                                        })
                                        ->orderByDesc("data_pengajuan_reimbursement.created_at")
                                        ->whereNull('users.deleted_at')
                                        ->paginate($limit);

        $qr->appends(request()->all());


        $reimbursement = ReimbursementPengajuanResource::collection($qr);

        return inertia('Pengajuan/Reimbursement/Index', compact('reimbursement'));
    }

    public function approved(DataPengajuanReimbursement $reimbursement)
    {
        return inertia('Pengajuan/Reimbursement/Approved', compact('reimbursement'));
    }

    public function reject(DataPengajuanReimbursement $reimbursement)
    {
        $komentar = request('komentar');

        $no_hp = $reimbursement?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$reimbursement?->reimbursement?->nama} Ditolak karena $komentar"));
        }

        tambah_log($reimbursement->nip, "App\Models\Pegawai\DataPengajuanReimbursement", $reimbursement->id, 'tolak');
        $up = $reimbursement->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.reimbursement.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.reimbursement.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, ditolak!"
            ]);
        }
    }

    public function update()
    {
        request()->validate([
            'id' => 'required',
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required',
            'komentar' => 'nullable',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png',
        ]);

        $id = request('id');
        $komentar = request('komentar');

        $reimbursement = DataPengajuanReimbursement::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($reimbursement->nip, $reimbursement->nip . "-reimbursement-" . request('nomor_surat') . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
            'nomor_surat' => request('nomor_surat'),
            'tanggal_surat' => request('tanggal_surat'),
        ];

        tambah_log($reimbursement->nip, "App\Models\Pegawai\DataPengajuanReimbursement", $id, 'terima');

        $up = $reimbursement->update($pengajuan);

        if ($up) {
            $no_hp = $reimbursement?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if($komentar){
                    $catatan = ", Catatan : $komentar"; 
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$reimbursement?->reimbursement?->nama} telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.reimbursement.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.reimbursement.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
}
