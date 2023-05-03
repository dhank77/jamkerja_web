<?php

namespace App\Http\Controllers\Master\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\Payroll\AbsensiPermenitResource;
use App\Models\Master\Payroll\AbsensiPermenit;
use Illuminate\Http\Request;

class AbsensiPermenitController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $absensiPermenit = AbsensiPermenit::with('eselon')
                            ->when($search, function($qr, $search){
                                $qr->where('keterangan', 'LIKE', "%$search%");
                            })
                            ->where('kode_perusahaan', kp())
                            ->paginate($limit);

        $absensiPermenit->appends(request()->all());

        $absensiPermenit = AbsensiPermenitResource::collection($absensiPermenit);

        return inertia('Master/Payroll/AbsensiPermenit/Index', compact('absensiPermenit'));
    }

    public function add()
    {
        $absensiPermenit = new AbsensiPermenit();
        return inertia('Master/Payroll/AbsensiPermenit/Add', compact('absensiPermenit'));
    }

    public function edit(AbsensiPermenit $absensiPermenit)
    {
        return inertia('Master/Payroll/AbsensiPermenit/Add', compact('absensiPermenit'));
    }

    public function delete(AbsensiPermenit $absensiPermenit)
    {
        $cr = $absensiPermenit->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.payroll.absensiPermenit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.absensiPermenit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function update()
    {
        $rules = [
            'kode_eselon' => 'nullable',
            'keterangan' => 'required',
            'potongan' => 'required',
        ];

        $data = request()->validate($rules);

        $data['potongan'] = number_to_sql($data['potongan']);
        $data['kode_perusahaan'] = kp();

        if(request('id')){
            $cr = AbsensiPermenit::where('id', request('id'))->update($data);
        }else{
            $cr = AbsensiPermenit::create($data);
        }

        if ($cr) {
            return redirect(route('master.payroll.absensiPermenit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.absensiPermenit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
