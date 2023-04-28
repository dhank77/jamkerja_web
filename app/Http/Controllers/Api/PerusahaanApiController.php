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
        $perusahaan = Perusahaan::find(1);

        $perusahaan = PerusahaanApiResource::make($perusahaan);

        return $perusahaan;
    }
}
