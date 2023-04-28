<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::find(1);
        if(!$perusahaan){
            $perusahaan = new Perusahaan();
        }

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
        ]);
        $cek = Perusahaan::first();
        if(request()->file('logo')){
            request()->validate([
                'logo' => 'max:2048|mimes:jpg,jpeg,png',
            ]);
            if($cek && $cek->logo != ""){
                Storage::delete($cek->logo);
            }
            $data['logo'] = request()->file('logo')->store('uploads/logo');
        }
        
        if($cek){
            $id = $cek->id;
        }else{
            $id = request('id');
        }
        $up = Perusahaan::updateOrCreate(['id' => $id], $data);

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
