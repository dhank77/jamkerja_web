<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\PengajuanIjinResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pengajuan\PengajuanIjin;

class PengajuanIjinController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = PengajuanIjin::select('data_pengajuan_ijin.*', 'users.name as name')
                                ->leftJoin('users', 'users.nip', 'data_pengajuan_ijin.nip')
                                ->when($search, function ($qr, $search) {
                                    $qr->where('data_pengajuan_ijin.nip', 'LIKE', "%$search%")
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
                                ->orderByDesc("data_pengajuan_ijin.created_at")
                                ->whereNull('users.deleted_at')
                                ->paginate($limit);

        $qr->appends(request()->all());


        $ijin = PengajuanIjinResource::collection($qr);

        return inertia('Pengajuan/Ijin/Index', compact('ijin'));
    }

    public function approved(PengajuanIjin $ijin)
    {
        tambah_log($ijin->nip, "App\Models\Pengajuan\PengajuanIjin", $ijin->id, 'progress');
        $up = $ijin->update([
            'status' => '1',
        ]);
        if ($up) {
            $no_hp = $ijin?->user?->no_hp;
            if ($no_hp) {
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan ijin telah diterima!"));
            }
            return redirect(route('pengajuan.ijin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.ijin.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
        // return inertia('Pengajuan/Ijin/Approved', compact('ijin'));
    }

    public function reject(PengajuanIjin $ijin)
    {
        $komentar = request('komentar');

        $no_hp = $ijin?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$ijin?->ijin?->nama} Ditolak karena $komentar"));
        }

        tambah_log($ijin->nip, "App\Models\Pengajuan\PengajuanIjin", $ijin->id, 'tolak');
        $up = $ijin->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.ijin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.ijin.index'))->with([
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

        $ijin = PengajuanIjin::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($ijin->nip, $ijin->nip . "-ijin-" . request('nomor_surat') . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
        ];

        tambah_log($ijin->nip, "App\Models\Pengajuan\PengajuanIjin", $id, 'terima');

        $up = $ijin->update($pengajuan);

        if ($up) {
            $no_hp = $ijin?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if($komentar){
                    $catatan = ", Catatan : $komentar"; 
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$ijin?->ijin?->nama} telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.ijin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.ijin.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
}
