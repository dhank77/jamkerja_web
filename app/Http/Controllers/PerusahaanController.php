<?php

namespace App\Http\Controllers;

use App\Http\Resources\PerusahaanResource;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::latest()->get();

        $search = request('s');
        $limit = request('limit') ?? 10;

        $perusahaan = Perusahaan::when($search, function ($qr, $search) {
                            $qr->where('nama', 'LIKE', "%$search%")
                            ->orWhere('kode', 'LIKE', "%$search%");
                        })
                        ->paginate($limit);
        $perusahaan->appends(request()->all());

        $perusahaan = PerusahaanResource::collection($perusahaan);

        return inertia('Perusahaan/Index', compact('perusahaan'));
    }

    public function add()
    {
        $perusahaan = new Perusahaan();
        return inertia('Perusahaan/Edit', compact('perusahaan'));
    }

    public function edit(Perusahaan $perusahaan)
    {
        return inertia('Perusahaan/Edit', compact('perusahaan'));
    }

    public function update()
    {
        $data = request()->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kontak' => 'nullable',
            'direktur' => 'required',
            'nomor' => 'nullable',
            'status' => 'required',
            'jumlah_pegawai' => 'required',
            'expired_at' => 'required',
        ]);
        $id = request('id');
        
        if(request()->file('logo')){
            request()->validate([
                'logo' => 'max:2048|mimes:jpg,jpeg,png',
            ]);
            if($id){
                $logo = Perusahaan::where('id', $id)->value('logo');
                Storage::delete($logo);
            }
            $data['logo'] = request()->file('logo')->store('uploads/logo');
        }

        if(!$id){
            $data['kode_perusahaan'] = generateUUID();
        }
        if($id){
            $up = Perusahaan::where('id', $id)->update($data);
        }else{
            $up = Perusahaan::create($data);
        }

        if($up){
            return redirect(route('perusahaan.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil!'
            ]);
        }else{
            return redirect(route('perusahaan.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal!'
            ]);
        }

    }
}
