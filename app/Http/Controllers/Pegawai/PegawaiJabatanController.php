<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\JabatanResource;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiJabatanController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rjabatan = RiwayatJabatan::with('tingkat')
            ->where('nip', $pegawai->nip)
            ->when($search, function ($qr, $search) {
                $qr->whereHas('tingkat', function ($qrt) use ($search) {
                    $qrt->where('nama', 'LIKE', "%$search%");
                });
            })
            ->orderByDesc('tanggal_tmt')
            ->paginate($limit);

        $Rjabatan->appends(request()->all());

        $Rjabatan = JabatanResource::collection($Rjabatan);
        return inertia('Pegawai/Jabatan/Index', compact('pegawai', 'Rjabatan'));
    }

    public function add(User $pegawai)
    {
        $Rjabatan = new RiwayatJabatan();
        return inertia('Pegawai/Jabatan/Add', compact('pegawai', 'Rjabatan'));
    }

    public function edit(User $pegawai, RiwayatJabatan $Rjabatan)
    {
        return inertia('Pegawai/Jabatan/Add', compact('pegawai', 'Rjabatan'));
    }

    public function delete(User $pegawai, RiwayatJabatan $Rjabatan)
    {
        if ($Rjabatan->file) {
            Storage::delete($Rjabatan->file);
        }
        $cr = $Rjabatan->delete();
        if ($cr) {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, RiwayatJabatan $Rjabatan)
    {
        RiwayatJabatan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $Rjabatan->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'no_sk' => 'nullable',
            'kode_skpd' => 'required',
            'kode_tingkat' => 'required',
            'jenis_jabatan' => 'required',
            'no_sk' => 'nullable',
            'tanggal_sk' => 'nullable',
            'tanggal_tmt' => 'nullable',
            'sebagai' => 'nullable',
            'is_akhir' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        if (request('is_akhir') == 1) {
            $data['sebagai'] = "defenitif";
            RiwayatJabatan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatJabatan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-jabatan-" . date("YmdHis") . ".pdf");
        }

        if($id){
            $cr = RiwayatJabatan::where('id', $id)->where('nip', $pegawai->nip)->update($data);
        }else{
            $data['nip'] = $pegawai->nip;
            $data['kode_perusahaan'] = kp();
            $cr = RiwayatJabatan::create($data);
        }


        if ($cr) {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
