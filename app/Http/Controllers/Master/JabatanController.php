<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JabatanResource;
use App\Http\Resources\Select\AtasanResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Eselon;
use App\Models\Master\Jabatan;
use App\Models\Master\Skpd;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class JabatanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $jabatan = Jabatan::when($search, function($qr, $search){
                        $qr->where('nama', 'LIKE', "%$search%");
                    })
                    ->paginate($limit);

        $jabatan->appends(request()->all());

        $jabatan = JabatanResource::collection($jabatan);

        return inertia('Master/Jabatan/Index', compact('jabatan'));
    }

    public function add()
    {
        $jabatan = new Jabatan();

        $skpd = Skpd::orderBy('nama')->get();
        $skpd = SelectResource::collection($skpd);

        $eselon = Eselon::orderBy('nama')->get();
        $eselon = SelectResource::collection($eselon);

        return inertia('Master/Jabatan/Add', compact('jabatan', 'skpd', 'eselon'));
    }

    public function edit(Jabatan $jabatan)
    {
        $skpd = Skpd::orderBy('nama')->get();
        $skpd = SelectResource::collection($skpd);

        $eselon = Eselon::orderBy('nama')->get();
        $eselon = SelectResource::collection($eselon);
        
        return inertia('Master/Jabatan/Add', compact('jabatan', 'skpd', 'eselon'));
    }

    public function delete(Jabatan $jabatan)
    {
        $cr = $jabatan->delete();
        if ($cr) {
            return redirect(route('master.jabatan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jabatan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_skpd' => 'required',
            'kode_bidang' => 'nullable',
            'kode_seksi' => 'nullable',
            'kode_atasan' => 'nullable',
            'kode_jabatan' => 'required',
            'nama' => 'required',
            'jenis_jabatan' => 'required',
            'kode_eselon' => 'required',
            'batas_pensiun' => 'nullable',
            'kebutuhan' => 'nullable',
            'kelas_jabatan' => 'nullable',
        ];

        if(!request('id')){
            $rules['kode_jabatan'] = 'required|unique:jabatan';
        }

        $data = request()->validate($rules);

        $cr = Jabatan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.jabatan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jabatan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    // Get Data
    public function atasan($skpd)
    {
        $data = Jabatan::where('kode_skpd', $skpd)->get();
        AtasanResource::withoutWrapping();
        $data = AtasanResource::collection($data);
        return response()->json($data);
    }

    public function json()
    {
        $jenis = request('jenis');
        $skpd = request('skpd');
        $bidang = request('bidang');
        $seksi = request('seksi');
        
        $data = Jabatan::orderBy('nama')
                    ->when($jenis, function($qr, $jenis){
                        $qr->where('jenis_jabatan', $jenis);
                    })
                    ->when($skpd, function($qr, $skpd){
                        $qr->where('kode_skpd', $skpd);
                    })
                    ->when($bidang, function($qr, $bidang){
                        $qr->where('kode_bidang', $bidang);
                    })
                    ->when($seksi, function($qr, $seksi){
                        $qr->where('kode_seksi', $seksi);
                    })
                    ->get();
        $data = SelectResource::collection($data);

        return response()->json($data);
    }
}
