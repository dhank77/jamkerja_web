<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PayrollPotonganResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Payroll\Potongan;
use Illuminate\Http\Request;

class PayrollPotonganController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $potongan = Potongan::when($search, function($qr, $search){
                        $qr->where('nama', 'LIKE', "%$search%");
                    })
                    ->where('kode_perusahaan', kp())
                    ->paginate($limit);

        $potongan->appends(request()->all());

        $potongan = PayrollPotonganResource::collection($potongan);

        return inertia('Master/Payroll/Potongan/Index', compact('potongan'));
    }

    public function json()
    {
        $potongan = Potongan::orderBy('nama')->where('kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $potongan = SelectResource::collection($potongan);

        return response()->json($potongan);
    }

    public function add()
    {
        $potongan = new Potongan();
        return inertia('Master/Payroll/Potongan/Add', compact('potongan'));
    }

    public function edit(Potongan $potongan)
    {
        return inertia('Master/Payroll/Potongan/Add', compact('potongan'));
    }

    public function delete(Potongan $potongan)
    {
        $cr = $potongan->delete();
        if ($cr) {
            return redirect(route('master.payroll.potongan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.potongan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_potongan' => 'required',
            'nama' => 'required',
        ];

        if(!request('id')){
            $rules['kode_potongan'] = 'required|unique:ms_potongan';
        }

        $data = request()->validate($rules);

        $cr = Potongan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.payroll.potongan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.potongan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
