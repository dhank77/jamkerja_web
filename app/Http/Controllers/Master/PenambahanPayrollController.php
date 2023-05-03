<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PenambahanPayrollResource;
use App\Http\Resources\Select\SelectResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Payroll\Tambahan;
use App\Models\Master\Payroll\Tunjangan;
use App\Models\Master\Tingkat;

class PenambahanPayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $tambahan = Tambahan::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->where('kode_perusahaan', kp())
            ->paginate($limit);

        $tambahan->appends(request()->all());

        $tambahan = PenambahanPayrollResource::collection($tambahan);

        return inertia('Master/Payroll/Tambahan/Index', compact('tambahan'));
    }

    public function json()
    {
        $tambahan = Tambahan::orderBy('nama')->where('kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $tambahan = SelectResource::collection($tambahan);

        return response()->json($tambahan);
    }

    public function add()
    {
        $tambahan = new Tambahan();
        return inertia('Master/Payroll/Tambahan/Add', compact('tambahan'));
    }

    public function edit(Tambahan $tambahan)
    {
        $tunjangan = array_map('trim', explode(',', $tambahan->kode_persen));
        SelectResource::withoutWrapping();
        $tambahan->kode_persen = SelectResource::collection(Tunjangan::whereIn("kode_tunjangan", $tunjangan)->get());
        return inertia('Master/Payroll/Tambahan/Add', compact('tambahan'));
    }

    public function delete(Tambahan $tambahan)
    {
        $cr = $tambahan->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'satuan' => 'required',
            'nilai' => 'required',
        ];

        if (request('satuan') == '2') {
            $rules['kode_persen'] = 'required';
        }

        $data = request()->validate($rules);

        $kode = [];
        foreach (request('kode_persen') as $k) {
            array_push( $kode, trim($k['kode_tunjangan']));
        }

        $data['kode_persen'] = implode(',', $kode);
        $data['nilai'] = number_to_sql($data['nilai']);

        
        if(request('id')){
            $cr = Tambahan::where('id', request('id'))->update($data);
        }else{
            $data['kode_tambah'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Tambahan::create($data);
        }


        if ($cr) {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
