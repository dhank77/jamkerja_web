<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\LemburPengajuanResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pegawai\DataPengajuanLembur;

class LemburPengajuanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = DataPengajuanLembur::select('data_pengajuan_lembur.*', 'users.name as name')
            ->leftJoin('users', 'users.nip', 'data_pengajuan_lembur.nip')
            ->when($search, function ($qr, $search) {
                $qr->where('data_pengajuan_lembur.nip', 'LIKE', "%$search%")
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
            ->orderByDesc("data_pengajuan_lembur.created_at")
            ->whereNull('users.deleted_at')
            ->where('users.kode_perusahaan', kp())
            ->paginate($limit);

        $qr->appends(request()->all());


        $lembur = LemburPengajuanResource::collection($qr);

        return inertia('Pengajuan/Lembur/Index', compact('lembur'));
    }

    public function approved(DataPengajuanLembur $lembur)
    {
        tambah_log($lembur->nip, "App\Models\Pegawai\DataPengajuanLembur", $lembur->id, 'progress');
        $up = $lembur->update([
            'status' => '1',
        ]);
        if ($up) {
            $no_hp = $lembur?->user?->no_hp;
            if ($no_hp) {
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan lembur telah diterima!"));
            }
            return redirect(route('pengajuan.lembur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.lembur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
        // return inertia('Pengajuan/Lembur/Approved', compact('lembur'));
    }

    public function reject(DataPengajuanLembur $lembur)
    {
        $komentar = request('komentar');

        $no_hp = $lembur?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan Lembur Ditolak karena $komentar"));
        }

        tambah_log($lembur->nip, "App\Models\Pegawai\DataPengajuanLembur", $lembur->id, 'tolak');
        $up = $lembur->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.lembur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.lembur.index'))->with([
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

        $lembur = DataPengajuanLembur::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($lembur->nip, $lembur->nip . "-lembur-" . request('nomor_surat') . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
            'nomor_surat' => request('nomor_surat'),
            'tanggal_surat' => request('tanggal_surat'),
        ];

        tambah_log($lembur->nip, "App\Models\Pegawai\DataPengajuanLembur", $id, 'terima');

        $up = $lembur->update($pengajuan);

        if ($up) {

            $no_hp = $lembur?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if($komentar){
                    $catatan = ", Catatan : $komentar"; 
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan Lembur telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.lembur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.lembur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
}
