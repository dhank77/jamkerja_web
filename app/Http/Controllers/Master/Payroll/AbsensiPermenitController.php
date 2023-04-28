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
        $cr = $absensiPermenit->delete();
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

        $cr = AbsensiPermenit::updateOrCreate(['id' => request('id')], $data);

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
