<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PenguranganPayrollResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Payroll\Pengurangan;
use App\Models\Master\Payroll\Tunjangan;

class PenguranganPayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $pengurangan = Pengurangan::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->where('kode_perusahaan', kp())
            ->paginate($limit);

        $pengurangan->appends(request()->all());

        $pengurangan = PenguranganPayrollResource::collection($pengurangan);

        return inertia('Master/Payroll/Pengurangan/Index', compact('pengurangan'));
    }

    public function json()
    {
        $pengurangan = Pengurangan::orderBy('nama')->where('kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $pengurangan = SelectResource::collection($pengurangan);

        return response()->json($pengurangan);
    }

    public function add()
    {
        $pengurangan = new Pengurangan();
        return inertia('Master/Payroll/Pengurangan/Add', compact('pengurangan'));
    }

    public function edit(Pengurangan $pengurangan)
    {
        $tunjangan = array_map('trim', explode(',', $pengurangan->kode_persen));
        SelectResource::withoutWrapping();
        $pengurangan->kode_persen = SelectResource::collection(Tunjangan::whereIn("kode_tunjangan", $tunjangan)->get());
        return inertia('Master/Payroll/Pengurangan/Add', compact('pengurangan'));
    }

    public function delete(Pengurangan $pengurangan)
    {
        $cr = $pengurangan->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.payroll.pengurangan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.pengurangan.index'))->with([
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
            $cr = Pengurangan::where('id', request('id'))->update($data);
        }else{
            $data['kode_kurang'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Pengurangan::create($data);
        }

        if ($cr) {
            return redirect(route('master.payroll.pengurangan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.pengurangan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
