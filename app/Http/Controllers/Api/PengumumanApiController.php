<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengumumanResource;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanApiController extends Controller
{
    public function index()
    {
        $qr = Pengumuman::latest()->paginate(5);
        PengumumanResource::collection($qr);

        return response()->json($qr);
    }

    public function count()
    {
        $count = Pengumuman::whereDate('created_at', date('Y-m-d'))->count();
        return response()->json(['count' => $count]);
    }

    public function detail(Pengumuman $pengumuman)
    {
        $pengumuman = PengumumanResource::make($pengumuman);
        return response()->json($pengumuman);
    }
}
