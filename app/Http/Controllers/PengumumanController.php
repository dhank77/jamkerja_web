<?php

namespace App\Http\Controllers;

use App\Http\Resources\PengumumanResource;
use App\Jobs\ProcessOneSignalAllMember;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PengumumanController extends Controller
{
    const DS = DIRECTORY_SEPARATOR;
    public function index()
    {
        // $scriptPath = app_path('Console' . self::DS . 'Scripts' . self::DS . '66');
        // if(!is_dir($scriptPath)){
        //     return ['confidence' => 101, 'id' => 'no_face'];
        // }
        // die('as');
        $search = request('s');
        $limit = request('limit') ?? 10;

        $pengumuman = Pengumuman::when($search, function ($qr, $search) {
                        $qr->where('nama', 'LIKE', "%$search%")->orWhere('kode', 'LIKE', "%$search%");
                    })->paginate($limit);
        $pengumuman->appends(request()->all());

        $pengumuman = PengumumanResource::collection($pengumuman);

        return inertia('Pengumuman/Index', compact('pengumuman'));
    }
    
    public function edit(Pengumuman $pengumuman)
    {
        return inertia('Pengumuman/Edit', compact('pengumuman'));
    }

    public function add()
    {
        $pengumuman = new Pengumuman();
        return inertia('Pengumuman/Edit', compact('pengumuman'));
    }
    

    public function store()
    {
        $data = request()->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);
        if(request()->file('file')){
            request()->validate([
                'file' => 'max:2048|mimes:pdf,jpg,jpeg,png',
            ]);
        }

        if(request('id') == ''){
            $data['file'] = request()->file('file') ? request()->file('file')->store('uploads/pengumuman') : '';
            dispatch(new ProcessOneSignalAllMember("Pengumuman!", request("judul")));
            $up = Pengumuman::create($data);
        }else{
            if(request()->file('file')){
                $data['file'] = request()->file('file')->store('uploads/pengumuman');
            }
            dispatch(new ProcessOneSignalAllMember("Perubahan Pengumuman!", request("judul")));
            $up = Pengumuman::where('id', request('id'))->update($data);
        }

        if($up){
            return redirect(route('pengumuman.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil!'
            ]);
        }else{
            return redirect(route('pengumuman.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal!'
            ]);
        }
    }

    public function delete(Pengumuman $pengumuman)
    {
        if($pengumuman->file){
            Storage::delete($pengumuman->file);
        }
        $pengumuman->delete();
        return redirect(route('pengumuman.index'))->with([
            'type' => 'success',
            'messages' => 'Berhasil!'
        ]);
    }
}
