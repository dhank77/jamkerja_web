<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PosisiResource;
use App\Models\User;

class DataPosisiControlller extends Controller
{
    public function index(User $pegawai)
    {
        PosisiResource::withoutWrapping();
        $pegawai = PosisiResource::make($pegawai);
        return inertia('Pegawai/Posisi/Index', compact('pegawai'));
    }
}
