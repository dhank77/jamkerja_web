<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\User;

class DataKordinatController extends Controller
{
    public function index(User $pegawai)
    {
        return inertia('Pegawai/Kordinat/Index', compact('pegawai'));
    }

    public function store(User $pegawai)
    {
        $cr = $pegawai->update([
            'kordinat' => request('kordinat'),
            'latitude' => request('latitude'),
            'longitude' => request('longitude'),
            'jarak' => request('jarak'),
        ]);
        if ($cr) {
            return redirect(route('pegawai.kordinat.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.kordinat.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function reset(User $pegawai)
    {
        $cr = $pegawai->update([
            'kordinat' => null,
            'latitude' => null,
            'longitude' => null,
            'jarak' => 0,
        ]);
        if ($cr) {
            return redirect(route('pegawai.kordinat.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, direset!"
            ]);
        } else {
            return redirect(route('pegawai.kordinat.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, direset!"
            ]);
        }
    }
}
