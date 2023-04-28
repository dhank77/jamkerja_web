<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatTunjanganResource;
use App\Models\Pegawai\RiwayatTunjangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatTunjanganController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $nOwner = !role('owner');

        $Rtunjangan = RiwayatTunjangan::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->when($nOwner, function($qr){
                $qr->where('is_private', 0);
            })
            ->paginate($limit);

        $Rtunjangan->appends(request()->all());
        $Rtunjangan = RiwayatTunjanganResource::collection($Rtunjangan);
        return inertia('Pegawai/Tunjangan/Index', compact('pegawai', 'Rtunjangan'));
    }

    public function add(User $pegawai)
    {
        $Rtunjangan = new RiwayatTunjangan();
        return inertia('Pegawai/Tunjangan/Add', compact('pegawai', 'Rtunjangan'));
    }

    public function edit(User $pegawai, RiwayatTunjangan $Rtunjangan)
    {
        return inertia('Pegawai/Tunjangan/Add', compact('pegawai', 'Rtunjangan'));
    }

    public function delete(User $pegawai, RiwayatTunjangan $Rtunjangan)
    {
        tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatTunjangan", $Rtunjangan->id, 'dihapus');
        if ($Rtunjangan->file) {
            Storage::delete($Rtunjangan->file);
        }
        $cr = $Rtunjangan->delete();
        if ($cr) {
            return redirect(route('pegawai.tunjangan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.tunjangan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, RiwayatTunjangan $Rtunjangan)
    {
        if($Rtunjangan->is_aktif == 1){
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatTunjangan", $Rtunjangan->id, 'dinonaktifkan');
            $cr = $Rtunjangan->update(['is_aktif' => 0]);
        }else{
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatTunjangan", $Rtunjangan->id, 'diaktifkan');
            $cr = $Rtunjangan->update(['is_aktif' => 1]);
        }
        if ($cr) {
            return redirect(route('pegawai.tunjangan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.tunjangan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nomor_sk' => 'required',
            'tanggal_sk' => 'required',
            'kode_tunjangan' => 'required',
            'nilai' => 'required',
            'is_aktif' => 'required',
            'is_private' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $data['nilai'] = number_to_sql($data['nilai']);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatTunjangan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatTunjangan", $id, 'diubah');
        }
        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-tunjangan-" . date("Ymdhis") . ".pdf");
        }

        $cr = RiwayatTunjangan::updateOrCreate(
                                    [
                                        'id' => $id,
                                        'nip' => $pegawai->nip,
                                    ],
                                    $data
                                );
        if (!$id) {
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatTunjangan", $cr->id, 'ditambahkan');
        }


        if ($cr) {
            return redirect(route('pegawai.tunjangan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.tunjangan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
