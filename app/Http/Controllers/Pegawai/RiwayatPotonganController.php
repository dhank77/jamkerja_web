<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPotonganResource;
use App\Models\Pegawai\RiwayatPotongan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RiwayatPotonganController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $nOwner = !role('owner');

        $Rpotongan = RiwayatPotongan::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->when($nOwner, function($qr){
                $qr->where('is_private', 0);
            })
            ->paginate($limit);

        $Rpotongan->appends(request()->all());
        $Rpotongan = RiwayatPotonganResource::collection($Rpotongan);
        return inertia('Pegawai/Potongan/Index', compact('pegawai', 'Rpotongan'));
    }

    public function add(User $pegawai)
    {
        $Rpotongan = new RiwayatPotongan();
        return inertia('Pegawai/Potongan/Add', compact('pegawai', 'Rpotongan'));
    }

    public function edit(User $pegawai, RiwayatPotongan $Rpotongan)
    {
        return inertia('Pegawai/Potongan/Add', compact('pegawai', 'Rpotongan'));
    }

    public function delete(User $pegawai, RiwayatPotongan $Rpotongan)
    {
        tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotongan", $Rpotongan->id, 'dihapus');
        if ($Rpotongan->file) {
            Storage::delete($Rpotongan->file);
        }
        $cr = $Rpotongan->delete();
        if ($cr) {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, RiwayatPotongan $Rpotongan)
    {
        if($Rpotongan->is_aktif == 1){
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotongan", $Rpotongan->id, 'dinonaktifkan');
            $cr = $Rpotongan->update(['is_aktif' => 0]);
        }else{
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotongan", $Rpotongan->id, 'diaktifkan');
            $cr = $Rpotongan->update(['is_aktif' => 1]);
        }
        if ($cr) {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nomor_sk' => 'nullable',
            'tanggal_sk' => 'nullable',
            'kode_kurang' => 'required',
            'is_aktif' => 'required',
            'is_private' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPotongan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotongan", $id, 'diubah');
        }
        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-potongan-" . generateRandomString(5) . ".pdf");
        }

        if($id){
            $cr = RiwayatPotongan::where('id', $id)->where('nip', $pegawai->nip)->update($data);
        }else{
            $data['nip'] = $pegawai->nip;
            $data['kode_perusahaan'] = kp();
            $cr = RiwayatPotongan::create($data);
        }

        if (!$id) {
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotongan", $cr->id, 'ditambahkan');
        }


        if ($cr) {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
