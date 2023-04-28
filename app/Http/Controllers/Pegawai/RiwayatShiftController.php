<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatShiftResource;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatShiftController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rshift = RiwayatShift::where('nip', $pegawai->nip)
                                ->orderByDesc('created_at')
                                ->whereRaw("(status = 99 OR status = 1)")
                                ->paginate($limit);

        $Rshift->appends(request()->all());
        $Rshift = RiwayatShiftResource::collection($Rshift);
        return inertia('Pegawai/Shift/Index', compact('pegawai', 'Rshift'));
    }

    public function add(User $pegawai)
    {
        $Rshift = new RiwayatShift();
        return inertia('Pegawai/Shift/Add', compact('pegawai', 'Rshift'));
    }

    public function edit(User $pegawai, RiwayatShift $Rshift)
    {
        return inertia('Pegawai/Shift/Add', compact('pegawai', 'Rshift'));
    }

    public function delete(User $pegawai, RiwayatShift $Rshift)
    {
        tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatShift", $Rshift->id, 'dihapus');
        $cr = $Rshift->delete();
        if ($cr) {
            return redirect(route('pegawai.shift.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.shift.index', $pegawai->nip))->with([
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
            'kode_shift' => 'required',
            'is_akhir' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data["status"] = "99";

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatShift::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatShift", $id, 'diubah');
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-shift-" . request('nomor_surat') . ".pdf");
        }

        $cr = RiwayatShift::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        if(!$id){
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatShift", $cr->id, 'ditambahkan');
        }

        if ($cr) {
            return redirect(route('pegawai.shift.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.shift.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
