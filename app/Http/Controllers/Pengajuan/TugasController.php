<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\TugasResource;
use App\Http\Resources\Select\SelectResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pengajuan\Tugas;
use App\Models\User;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = Tugas::select('tugas.*', 'users.name as name')
                    ->leftJoin('users', 'users.nip', 'tugas.nip')
                    ->when($search, function ($qr, $search) {
                        $qr->where('tugas.nip', 'LIKE', "%$search%")
                            ->orWhere('users.name', 'LIKE', "%$search%");
                    })
                    ->when($role, function ($qr) {
                        $qr->where("tugas.nip", auth()->user()->nip);
                    })
                    ->orderByDesc("tugas.created_at")
                    ->whereNull('users.deleted_at')
                    ->where('users.kode_perusahaan', kp())
                    ->paginate($limit);

        $qr->appends(request()->all());

        $tugas = TugasResource::collection($qr);
        return inertia('Pengajuan/Tugas/Index', compact('tugas'));
    }

    public function add()
    {
        $tugas = new Tugas();
        $kepala_divisi = User::where("kepala_divisi_id", "!=", null)->get();
        SelectResource::withoutWrapping();
        $kepala_divisi = SelectResource::collection($kepala_divisi);
        return inertia("Pengajuan/Tugas/Add", compact("tugas", "kepala_divisi"));
    }

    public function update()
    {
        request()->validate([
            'nip' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'nullable',
        ]);

        $nip = request('nip');
        $keterangan = request('deskripsi');
        $tanggal_mulai = request('tanggal_mulai') ?? date("Y-m-d");
        $tanggal_selesai = request('tanggal_selesai') ?? date("Y-m-d");

        $user = User::where('nip', $nip)->first();
        if ($user) {
            $data = [
                'nip' => $nip,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'hari' => count(getBetweenDates($tanggal_mulai, $tanggal_selesai)),
                'keterangan' => $keterangan,
            ];

            $cek = Tugas::where('nip', $nip)->where('status', 0)->count();
            if ($cek > 0) {
                return response()->json(['status' => FALSE, 'messages' => 'Anda tugas yang belum diselesaikan!']);
            }

            $cr = Tugas::create($data);
            if ($cr) {
                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Admin telah memberikan anda tugas, segera konfirmasi!"));
                tambah_log($cr->nip, "App\Models\Pengajuan\Tugas", $cr->id, 'ditugaskan');
                return redirect(route('pengajuan.tugas.index'))->with([
                    'type' => 'success',
                    'messages' => "Berhasil!"
                ]);
            } else {
                return redirect(route('pengajuan.tugas.index'))->with([
                    'type' => 'error',
                    'messages' => "Gagal!"
                ]);
            }
        } else {
            return redirect(route('pengajuan.tugas.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function approved(Tugas $tugas)
    {
        tambah_log($tugas->nip, "App\Models\Pengajuan\Tugas", $tugas->id, 'progress');
        $up = $tugas->update([
            'status' => '1',
        ]);
        if ($up) {
            return redirect(route('pengajuan.tugas.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.tugas.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
    
    public function selesai(Tugas $tugas)
    {
        return inertia('Pengajuan/Tugas/Approved', compact('tugas'));
    }

    public function reject(Tugas $tugas)
    {
        $komentar = request('komentar');

        $no_hp = $tugas?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan tugas Ditolak karena $komentar"));
        }

        tambah_log($tugas->nip, "App\Models\Pengajuan\Tugas", $tugas->id, 'tolak');
        $up = $tugas->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.tugas.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.tugas.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, ditolak!"
            ]);
        }
    }

    public function update_selesai()
    {
        request()->validate([
            'id' => 'required',
            'komentar' => 'nullable',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png',
        ]);

        $id = request('id');
        $komentar = request('komentar');

        $tugas = Tugas::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($tugas->nip, $tugas->nip . "-tugas-" . date("Ymdhis") . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 3,
        ];

        tambah_log($tugas->nip, "App\Models\Pengajuan\Tugas", $id, 'selesai');

        $up = $tugas->update($pengajuan);

        if ($up) {
            return redirect(route('pengajuan.tugas.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diselesaikan!"
            ]);
        } else {
            return redirect(route('pengajuan.tugas.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diselesaikan!"
            ]);
        }
    }

}
