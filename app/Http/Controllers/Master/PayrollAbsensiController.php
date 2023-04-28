<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PayrollAbsensiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Payroll\Absensi;
use App\Models\Master\Payroll\Tunjangan;

class PayrollAbsensiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $absensi = Absensi::when($search, function($qr, $search){
                        $qr->where('jam', 'LIKE', "%$search%");
                    })
                    ->paginate($limit);

        $absensi->appends(request()->all());

        $absensi = PayrollAbsensiResource::collection($absensi);

        return inertia('Master/Payroll/Absensi/Index', compact('absensi'));
    }

    public function edit(Absensi $absensi)
    {
        $tunjangan = array_map('trim', explode(',', $absensi->kode_tunjangan));
        SelectResource::withoutWrapping();
        $absensi->kode_tunjangan = SelectResource::collection(Tunjangan::whereIn("kode_tunjangan", $tunjangan)->get());
        return inertia('Master/Payroll/Absensi/Add', compact('absensi'));
    }

    public function update()
    {
        $rules = [
            'menit' => 'required',
            'kode_tunjangan' => 'required',
            'pengali' => 'required',
        ];

        $data = request()->validate($rules);
        $tunjanganString = "";
        foreach (request('kode_tunjangan') as $k => $tunjangan) {
            if($k == 0){
                $tunjanganString .= $tunjangan['kode_tunjangan'];
            }else{
                $tunjanganString .= ", " . $tunjangan['kode_tunjangan'];
            }
        }
        $data['kode_tunjangan'] = $tunjanganString;

        $cr = Absensi::where(['id' => request('id')])->update( $data);

        if ($cr) {
            return redirect(route('master.payroll.absensi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.absensi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
