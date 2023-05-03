<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PayrollLemburResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Payroll\Lembur;
use App\Models\Master\Payroll\Tunjangan;

class PayrollLemburController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $lembur = Lembur::when($search, function ($qr, $search) {
            $qr->where('jam', 'LIKE', "%$search%");
        })
            ->where('kode_perusahaan', kp())
            ->paginate($limit);

        $lembur->appends(request()->all());

        $lembur = PayrollLemburResource::collection($lembur);

        return inertia('Master/Payroll/Lembur/Index', compact('lembur'));
    }

    public function add()
    {
        $lembur = new Lembur();
        return inertia('Master/Payroll/Lembur/Add', compact('lembur'));
    }

    public function edit(Lembur $lembur)
    {
        $tunjangan = array_map('trim', explode(',', $lembur->kode_tunjangan));
        SelectResource::withoutWrapping();
        $lembur->kode_tunjangan = SelectResource::collection(Tunjangan::whereIn("kode_tunjangan", $tunjangan)->get());
        return inertia('Master/Payroll/Lembur/Add', compact('lembur'));
    }

    public function delete(Lembur $lembur)
    {
        $cr = $lembur->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.payroll.lembur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.lembur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function update()
    {
        $rules = [
            'jam' => 'required',
            'kode_tunjangan' => 'required',
            'pengali' => 'required',
        ];

        $data = request()->validate($rules);
        $tunjanganString = "";
        foreach (request('kode_tunjangan') as $k => $tunjangan) {
            if ($k == 0) {
                $tunjanganString .= $tunjangan['kode_tunjangan'];
            } else {
                $tunjanganString .= ", " . $tunjangan['kode_tunjangan'];
            }
        }
        $data['kode_tunjangan'] = $tunjanganString;
        $data['kode_perusahaan'] = kp();

        if(request('id')){
            $cr = Lembur::where(['id' => request('id')])->update($data);
        }else{
            $cek = Lembur::where(['jam' => request('jam')])->first();
            if($cek){
                $cr = Lembur::where(['jam' => request('jam')])->update($data);
            }else{
                $cr = Lembur::create($data);
            }
        }

        if ($cr) {
            return redirect(route('master.payroll.lembur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.lembur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
