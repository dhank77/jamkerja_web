<?php

namespace App\Http\Controllers\Pegawai;

use App\Exports\Pegawai\ProfileExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use ZipArchive;

class UnduhBerkasController extends Controller
{
    public function index(User $pegawai)
    {
        $nip = $pegawai->nip;
        $path = storage_path("app/public/$nip");
        $dataFile = [];

        if(is_dir($path)){
            $files = File::allFiles($path);
    
            foreach($files as $path) { 
                $file = pathinfo($path);
                $send = [
                    'file' => asset("storage/$nip/$file[basename]"),
                    'nama' => str_replace("$nip-", "", $file["basename"]),
                    'extension' =>  $file["extension"],
                ];
                array_push($dataFile, $send);
           }
        }

        return inertia('Pegawai/Berkas/Index', compact('pegawai', 'dataFile'));
    }

    public function profile(User $pegawai)
    {
        return inertia('Pegawai/Berkas/Profile', compact('pegawai'));
    }

    public function profile_pdf(User $pegawai)
    {
        // return view("pegawai.profile", compact('pegawai'));
        $pdf = PDF::loadView('pegawai.profile', compact('pegawai'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function profile_xls(User $pegawai)
    {
        return Excel::download(new ProfileExport($pegawai), "profil-pegawai-$pegawai->name.xlsx");
        // return view("pegawai.profile", compact('pegawai'));
    }

    public function berkas_zip(User $pegawai)
    {
        $nip = $pegawai->nip;
        $zip = new ZipArchive;

        if (true === ($zip->open("$nip.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE))) {
            $path = storage_path("app/public/$nip");
            $files = File::allFiles($path);
            
            foreach ($files as $file) {
                $name = basename($file);
                if ($name !== '.gitignore') {
                    $zip->addFile(storage_path("app/public/$nip/$name"), $name);
                }
            }
            $zip->close();
        }
    
        return response()->download(public_path("$nip.zip"), "$nip.zip");
    }
}
