<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\CutiPengajuanResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\RiwayatCuti;
use Illuminate\Http\Request;

class CutiPengajuanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = DataPengajuanCuti::select('data_pengajuan_cuti.*', 'users.name as name')
                                ->leftJoin('users', 'users.nip', 'data_pengajuan_cuti.nip')
                                ->when($search, function ($qr, $search) {
                                    $qr->where('data_pengajuan_cuti.nip', 'LIKE', "%$search%")
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
                                ->orderByDesc("data_pengajuan_cuti.created_at")
                                ->whereNull('users.deleted_at')
                                ->paginate($limit);

        $qr->appends(request()->all());


        $cuti = CutiPengajuanResource::collection($qr);

        return inertia('Pengajuan/Cuti/Index', compact('cuti'));
    }

    public function approved(DataPengajuanCuti $cuti)
    {
        tambah_log($cuti->nip, "App\Models\Pengajuan\DataPengajuanCuti", $cuti->id, 'progress');
        $up = $cuti->update([
            'status' => '1',
        ]);
        if ($up) {
            $no_hp = $cuti?->user?->no_hp;
            if ($no_hp) {
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan  {$cuti?->cuti?->nama} telah diterima!"));
            }
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
        // return inertia('Pengajuan/Cuti/Approved', compact('cuti'));
    }

    public function reject(DataPengajuanCuti $cuti)
    {
        $komentar = request('komentar');

        $no_hp = $cuti?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$cuti?->cuti?->nama} Ditolak karena $komentar"));
        }

        tambah_log($cuti->nip, "App\Models\Pegawai\DataPengajuanCuti", $cuti->id, 'tolak');
        $up = $cuti->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, ditolak!"
            ]);
        }
    }

    // status cuti, 0 progres, 1 terima, 2 tolak, 3 batal

    public function cancel(DataPengajuanCuti $cuti)
    {
        $komentar = request('komentar');
        $no_hp = $cuti?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$cuti?->cuti?->nama} telah dibatalkan"));
        }

        tambah_log($cuti->nip, "App\Models\Pegawai\DataPengajuanCuti", $cuti->id, 'batal');
        $up = $cuti->update([
            'komentar' => $komentar,
            'status' => '3',
        ]);

        if ($up) {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.cuti.index'))->with([
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

        $cuti = DataPengajuanCuti::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($cuti->nip, $cuti->nip . "-cuti-" . request('nomor_surat') . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
        ];

        tambah_log($cuti->nip, "App\Models\Pegawai\DataPengajuanCuti", $id, 'terima');

        $up = $cuti->update($pengajuan);

        if ($up) {
            RiwayatCuti::create([
                'nip' => $cuti->nip,
                'tanggal_mulai' => $cuti->tanggal_mulai,
                'tanggal_selesai' => $cuti->tanggal_selesai,
                'kode_cuti' => $cuti->kode_cuti,
                'file'  => $file,
                'nomor_surat' => request('nomor_surat'),
                'tanggal_surat' => request('tanggal_surat'),
            ]);

            $no_hp = $cuti?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if($komentar){
                    $catatan = ", Catatan : $komentar"; 
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$cuti?->cuti?->nama} telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
}
