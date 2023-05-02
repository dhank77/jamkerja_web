<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\VisitResource;
use App\Models\Master\Visit;
use Illuminate\Support\Str;

class VisitController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $visit = Visit::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->where('kode_perusahaan', kp())
            ->paginate($limit);

        $visit->appends(request()->all());

        $visit = VisitResource::collection($visit);

        return inertia('Master/Visit/Index', compact('visit'));
    }

    public function add()
    {
        $visit = new Visit();
        return inertia('Master/Visit/Add', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        return inertia('Master/Visit/Add', compact('visit'));
    }

    public function delete(Visit $visit)
    {
        $cr = $visit->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.visit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.visit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kordinat' => 'required',
            'jarak' => 'required',
            'nama' => 'required',
        ];

        $data = request()->validate($rules);
        if (!request('id')) {
            $data['kode_visit'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Visit::create($data);
        } else {
            $cr = Visit::where('id', request('id'))->update($data);
        }


        if ($cr) {
            return redirect(route('master.visit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.visit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
