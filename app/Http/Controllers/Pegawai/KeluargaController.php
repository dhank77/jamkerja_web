<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\KeluargaResource;
use App\Models\Pegawai\Keluarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeluargaController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
                    ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        $tambah = 0;
        return inertia('Pegawai/Keluarga/Index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function orang_tua(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
                    ->whereIn('status', ['ayah', 'ibu'])
                    ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        $tambah = "orang-tua";
        return inertia('Pegawai/Keluarga/Index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function anak(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
                    ->where('status', 'anak')
                    ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        $tambah = "anak";
        return inertia('Pegawai/Keluarga/Index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function pasangan(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
                    ->whereIn('status', ['suami', 'istri'])
                    ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        if($pegawai->jenis_kelamin == 'laki-laki'){
            $tambah = "istri";
        }else{
            $tambah = "suami";
        }
        return inertia('Pegawai/Keluarga/Index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function add(User $pegawai, $status)
    {
        $keluarga = new Keluarga();
        return inertia('Pegawai/Keluarga/Add', compact('pegawai', 'keluarga', 'status'));
    }

    public function edit(User $pegawai, $status = null, Keluarga $Rkeluarga)
    {
        $keluarga = $Rkeluarga;
        return inertia('Pegawai/Keluarga/Add', compact('pegawai', 'keluarga'));
    }

    public function delete(User $pegawai, Keluarga $keluarga)
    {
        if($keluarga->file_ktp){
            Storage::delete($keluarga->file_ktp);
        }
        if($keluarga->file_bpjs){
            Storage::delete($keluarga->file_bpjs);
        }
        if($keluarga->file_akta_kelahiran){
            Storage::delete($keluarga->file_akta_kelahiran);
        }
        $cr = $keluarga->delete();
        if ($cr) {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, Keluarga $keluarga)
    {
        Keluarga::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $keluarga->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'status' => 'required',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            // 'status_kehidupan' => 'required',
            'nip_keluarga' => 'nullable',
            'status_pernikahan' => 'nullable',
            'id_ibu' => 'nullable',
            'status_anak' => 'nullable',
            'anak_ke' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'alamat' => 'nullable',
            'nomor_telepon' => 'nullable',
            'nomor_ktp' => 'nullable',
            'nomor_bpjs' => 'nullable',
            'nomor_akta_kelahiran' => 'nullable',
        ];

        if (request()->file('file_ktp')) {
            $rules['file_ktp'] = 'mimes:pdf|max:2048';
        }
        if (request()->file('file_bpjs')) {
            $rules['file_bpjs'] = 'mimes:pdf|max:2048';
        }
        if (request()->file('file_akta_kelahiran')) {
            $rules['file_akta_kelahiran'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        if (request('is_akhir') == 1) {
            Keluarga::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if($id){
            if(request()->file('file_ktp')){
                $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_ktp');
                if($file){
            Storage::delete($file);
        }
            }
            if(request()->file('file_bpjs')){
                $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_bpjs');
                if($file){
            Storage::delete($file);
        }
            }
            if(request()->file('file_akta_kelahiran')){
                $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_akta_kelahiran');
                if($file){
            Storage::delete($file);
        }
            }
        }

        if (request()->file('file_ktp')) {
            $data['file_ktp'] = request()->file('file_ktp')->storeAs($pegawai->nip, $pegawai->nip . "-ktp-" . request('status') . ".pdf");
        }
        if (request()->file('file_bpjs')) {
            $data['file_bpjs'] = request()->file('file_bpjs')->storeAs($pegawai->nip, $pegawai->nip . "-bpjs-" . request('status') . ".pdf");
        }
        if (request()->file('file_akta_kelahiran')) {
            $data['file_akta_kelahiran'] = request()->file('file_akta_kelahiran')->storeAs($pegawai->nip, $pegawai->nip . "-akta-" . request('status') . ".pdf");
        }

        $cr = Keluarga::updateOrCreate(
                                [
                                    'id' => $id,
                                    'nip' => $pegawai->nip,
                                ],
                                $data
                            );

        if ($cr) {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
