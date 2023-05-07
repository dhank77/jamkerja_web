<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PerusahaanApiResource;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanApiController extends Controller
{
    public function index()
    {

        $kode_perusahaan = request('kode_perusahaan');
        $perusahaan = Perusahaan::where('kode_perusahaan', $kode_perusahaan)->first();

        $perusahaan = PerusahaanApiResource::make($perusahaan);

        return $perusahaan;
    }
}
