<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\PengajuanSakitResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pengajuan\PengajuanSakit;

class PengajuanSakitController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = PengajuanSakit::select('data_pengajuan_sakit.*', 'users.name as name')
                                ->leftJoin('users', 'users.nip', 'data_pengajuan_sakit.nip')
                                ->when($search, function ($qr, $search) {
                                    $qr->where('data_pengajuan_sakit.nip', 'LIKE', "%$search%")
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
                                ->orderByDesc("data_pengajuan_sakit.created_at")
                                ->where('users.kode_perusahaan', kp())
                                ->whereNull('users.deleted_at')
                                ->paginate($limit);

        $qr->appends(request()->all());

        $sakit = PengajuanSakitResource::collection($qr);
        return inertia('Pengajuan/Sakit/Index', compact('sakit'));
    }

    public function approved(PengajuanSakit $sakit)
    {
        tambah_log($sakit->nip, "App\Models\Pengajuan\PengajuanSakit", $sakit->id, 'progress');
        $up = $sakit->update([
            'status' => '1',
        ]);
        if ($up) {
            $no_hp = $sakit?->user?->no_hp;
            if ($no_hp) {
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan sakit telah diterima!"));
            }
            return redirect(route('pengajuan.sakit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.sakit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
        // return inertia('Pengajuan/Sakit/Approved', compact('sakit'));
    }

    public function reject(PengajuanSakit $sakit)
    {
        $komentar = request('komentar');

        $no_hp = $sakit?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan sakit Ditolak karena $komentar"));
        }

        tambah_log($sakit->nip, "App\Models\Pengajuan\PengajuanSakit", $sakit->id, 'tolak');
        $up = $sakit->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.sakit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.sakit.index'))->with([
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

        $sakit = PengajuanSakit::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($sakit->nip, $sakit->nip . "-sakit-" . date("Ymdhis") . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
        ];

        tambah_log($sakit->nip, "App\Models\Pengajuan\PengajuanSakit", $id, 'terima');

        $up = $sakit->update($pengajuan);

        if ($up) {
            $no_hp = $sakit?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if($komentar){
                    $catatan = ", Catatan : $komentar"; 
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan sakit telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.sakit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.sakit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
}
