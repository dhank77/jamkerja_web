<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatShiftResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pegawai\RiwayatShift;

class ShiftPengajuanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = RiwayatShift::select('riwayat_shift.*', 'users.name as name')
                        ->leftJoin('users', 'users.nip', 'riwayat_shift.nip')
                        ->when($search, function ($qr, $search) {
                            $qr->where('riwayat_shift.nip', 'LIKE', "%$search%")
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
                        ->orderByDesc("riwayat_shift.created_at")
                        ->where('users.kode_perusahaan', kp())
                        ->where("status", '!=', 99)
                        ->whereNull('users.deleted_at')
                        ->paginate($limit);

        $qr->appends(request()->all());


        $shift = RiwayatShiftResource::collection($qr);
        return inertia('Pengajuan/Shift/Index', compact('shift'));
    }

    public function approved(RiwayatShift $shift)
    {
        return inertia('Pengajuan/Shift/Approved', compact('shift'));
    }

    public function reject(RiwayatShift $shift)
    {
        $komentar = request('komentar');

        $no_hp = $shift?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$shift?->shift?->nama} Ditolak karena $komentar"));
        }

        tambah_log($shift->nip, "App\Models\Pegawai\RiwayatShift", $shift->id, 'tolak');
        $up = $shift->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.shift.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.shift.index'))->with([
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

        $shift = RiwayatShift::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($shift->nip, $shift->nip . "-shift-" . request('nomor_surat') . "." . $ext);
        }

        RiwayatShift::where("nip", $shift->nip)->update(['is_akhir' => 0]);

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
            'is_akhir' => 1,
            'nomor_surat' => request('nomor_surat'),
            'tanggal_surat' => request('tanggal_surat'),
        ];

        tambah_log($shift->nip, "App\Models\Pegawai\RiwayatShift", $id, 'terima');

        $up = $shift->update($pengajuan);

        if ($up) {
            $no_hp = $shift?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if($komentar){
                    $catatan = ", Catatan : $komentar"; 
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$shift?->shift?->nama} telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.shift.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.shift.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
}
