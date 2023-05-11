<?php
namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPotonganCutiResource;
use App\Models\Pegawai\RiwayatPotonganCuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatPotonganCutiController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $nOwner = !role('owner');

        $Rpcuti = RiwayatPotonganCuti::where('nip', $pegawai->nip)
                                    ->paginate($limit);

        $Rpcuti->appends(request()->all());
        $Rpcuti = RiwayatPotonganCutiResource::collection($Rpcuti);
        return inertia('Pegawai/PotonganCuti/Index', compact('pegawai', 'Rpcuti'));
    }

    public function add(User $pegawai)
    {
        $Rpcuti = new RiwayatPotonganCuti();
        return inertia('Pegawai/PotonganCuti/Add', compact('pegawai', 'Rpcuti'));
    }

    public function edit(User $pegawai, RiwayatPotonganCuti $Rpcuti)
    {
        return inertia('Pegawai/PotonganCuti/Add', compact('pegawai', 'Rpcuti'));
    }

    public function delete(User $pegawai, RiwayatPotonganCuti $Rpcuti)
    {
        tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotonganCuti", $Rpcuti->id, 'dihapus');
        if ($Rpcuti->file) {
            Storage::delete($Rpcuti->file);
        }
        $cr = $Rpcuti->delete();
        if ($cr) {
            return redirect(route('pegawai.pcuti.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.pcuti.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'keterangan' => 'required',
            'tahun' => 'nullable',
            'hari' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tahun'] = $data['tahun'] ?? date('Y');

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPotonganCuti::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotonganCuti", $id, 'diubah');
        }
        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-potongan-" . generateRandomString(5) . ".pdf");
        }

        if($id){
            $cr = RiwayatPotonganCuti::where('id', $id)->where('nip', $pegawai->nip)->update($data);
        }else{
            $data['nip'] = $pegawai->nip;
            $data['kode_perusahaan'] = kp();
            $cr = RiwayatPotonganCuti::create($data);
        }

        if (!$id) {
            tambah_log($pegawai->nip, "App\Models\Pegawai\RiwayatPotonganCuti", $cr->id, 'ditambahkan');
        }


        if ($cr) {
            return redirect(route('pegawai.pcuti.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.pcuti.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
