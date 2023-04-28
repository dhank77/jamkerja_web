<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\WajahResource;
use App\Models\Pegawai\Wajah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WajahController extends Controller
{
    public function index(User $pegawai)
    {
        $wajah = Wajah::where('nip', $pegawai->nip)->get();
        WajahResource::withoutWrapping();
        $wajah = WajahResource::collection($wajah);
        return inertia('Pegawai/Wajah/Index', compact('pegawai', 'wajah'));
    }

    public function store(User $pegawai)
    {
        request()->validate([
            'file' => 'max:2048|mimes:jpg,jpeg,png',
        ]);

        if (request()->file('file')) {
            $file = request()->file('file')->storeAs("faces/" . $pegawai->nip, $pegawai->nip . "-face-" . date("YmdHis") . "." . request()->file('file')->extension());
            $cr = Wajah::create([
                'nip' => $pegawai->nip,
                'file' => $file,
            ]);

            $tr = train_image($pegawai->nip);
        }else{
            $cr = 0;
        }

        if ($cr) {
            return redirect(route('pegawai.wajah.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, tambahkan!"
            ]);
        } else {
            return redirect(route('pegawai.wajah.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, tambahkan!"
            ]);
        }
    }

    public function delete(User $pegawai, Wajah $wajah)
    {   
        if($wajah->file){
            Storage::delete($wajah->file);
        }
        $cr = $wajah->delete();
        if ($cr) {
            return redirect(route('pegawai.wajah.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.wajah.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }
}
