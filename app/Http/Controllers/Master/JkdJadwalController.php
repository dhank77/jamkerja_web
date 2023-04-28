<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JkdJadwalResource;
use App\Imports\Master\JadwalImport;
use App\Models\Master\JkdJadwal;
use Maatwebsite\Excel\Facades\Excel;

class JkdJadwalController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $bulan = request('bulan') ?? date("m");
        $tahun = request('tahun') ?? date("Y");

        $jkdJadwal = JkdJadwal::with('user')
                            ->whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->when($search, function($qr, $search){
                                $qr->whereHas('user', function($qrt) use($search){
                                    $qrt->where('name', 'LIKE', "%$search%");
                                });
                            })                            
                            ->paginate($limit);

        $jkdJadwal->appends(request()->all());
        $jkdJadwal = JkdJadwalResource::collection($jkdJadwal);


        return inertia('Master/JkdJadwal/Index', compact('jkdJadwal'));
    }


    public function add()
    {
        $jkdJadwal = new JkdJadwal();
        return inertia('Master/JkdJadwal/Add', compact('jkdJadwal'));
    }

    public function edit(JkdJadwal $jkdJadwal)
    {
        return inertia('Master/JkdJadwal/Add', compact('jkdJadwal'));
    }

    public function delete(JkdJadwal $jkdJadwal)
    {
        $cr = $jkdJadwal->delete();
        if ($cr) {
            return redirect(route('master.jamKerjaDinamis.jkdJadwal.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jamKerjaDinamis.jkdJadwal.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_jkd' => 'required',
            'nip' => 'required',
            'tanggal' => 'required',
        ];

        request()->validate($rules);

        $cr = JkdJadwal::updateOrCreate(
            [
                'nip' => request('nip'),
                'tanggal' => request('tanggal'),
            ],
            [
                'kode_jkd' => request('kode_jkd')
            ]
        );

        if ($cr) {
            return redirect(route('master.jamKerjaDinamis.jkdJadwal.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jamKerjaDinamis.jkdJadwal.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function import()
    {
        request()->validate([
            'file' => 'max:5120|mimes:xlsx,xls,csv',
        ]);
        $file = request()->file('file');
        $bulan = request('bulan') ?? date("m");
        $tahun = request('tahun') ?? date("Y");

        try {
            Excel::import(new JadwalImport($bulan, $tahun), $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                return redirect(route('master.jamKerjaDinamis.jkdJadwal.index'))->with([
                    'type' => 'error',
                    'messages' => $failure->errors()[0],
                ]);
            }
        }

        return redirect(route('master.jamKerjaDinamis.jkdJadwal.index'))->with([
            'type' => 'success',
            'messages' => "Berhasil diimport!"
        ]);
    }
}
