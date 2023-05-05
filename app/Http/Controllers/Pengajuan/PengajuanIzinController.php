<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\PengajuanIzinResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pengajuan\PengajuanIzin;

class PengajuanIzinController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = PengajuanIzin::select('data_pengajuan_izin.*', 'users.name as name')
                                ->leftJoin('users', 'users.nip', 'data_pengajuan_izin.nip')
                                ->when($search, function ($qr, $search) {
                                    $qr->where('data_pengajuan_izin.nip', 'LIKE', "%$search%")
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
                                ->orderByDesc("data_pengajuan_izin.created_at")
                                ->where('users.kode_perusahaan', kp())
                                ->whereNull('users.deleted_at')
                                ->paginate($limit);

        $qr->appends(request()->all());


        $izin = PengajuanIzinResource::collection($qr);

        return inertia('Pengajuan/Izin/Index', compact('izin'));
    }

    public function approved(PengajuanIzin $izin)
    {
        tambah_log($izin->nip, "App\Models\Pengajuan\PengajuanIzin", $izin->id, 'progress');
        $up = $izin->update([
            'status' => '1',
        ]);
        if ($up) {
            $no_hp = $izin?->user?->no_hp;
            if ($no_hp) {
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan izin telah diterima!"));
            }
            return redirect(route('pengajuan.izin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.izin.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
        // return inertia('Pengajuan/Izin/Approved', compact('izin'));
    }

    public function reject(PengajuanIzin $izin)
    {
        $komentar = request('komentar');

        $no_hp = $izin?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$izin?->izin?->nama} Ditolak karena $komentar"));
        }

        tambah_log($izin->nip, "App\Models\Pengajuan\PengajuanIzin", $izin->id, 'tolak');
        $up = $izin->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.izin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.izin.index'))->with([
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

        $izin = PengajuanIzin::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($izin->nip, $izin->nip . "-izin-" . request('nomor_surat') . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
        ];

        tambah_log($izin->nip, "App\Models\Pengajuan\PengajuanIzin", $id, 'terima');

        $up = $izin->update($pengajuan);

        if ($up) {
            $no_hp = $izin?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if($komentar){
                    $catatan = ", Catatan : $komentar"; 
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$izin?->izin?->nama} telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.izin.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.izin.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
}
