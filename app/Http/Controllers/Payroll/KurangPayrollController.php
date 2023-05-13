<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\KurangPayrollResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Tingkat;
use App\Models\Payroll\DaftarKurangPayroll;

class KurangPayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $kurang = DaftarKurangPayroll::latest()->where('kode_perusahaan', kp())->paginate($limit);

        $kurang->appends(request()->all());
        $kurang = KurangPayrollResource::collection($kurang);
        return inertia('Payroll/Kurang/Index', compact('kurang'));
    }

    public function add()
    {
        $kurang = new DaftarKurangPayroll();
        $parent = Tingkat::with(str_repeat('children.', 99))->where('kode_perusahaan', kp())->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Payroll/Kurang/Add', compact('kurang', 'parent'));
    }

    public function edit(DaftarKurangPayroll $kurang)
    {
        $parent = Tingkat::with(str_repeat('children.', 99))->where('kode_perusahaan', kp())->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Payroll/Kurang/Add', compact('kurang', 'parent'));
    }

    public function delete(DaftarKurangPayroll $kurang)
    {
        $cr = $kurang->delete();
        if ($cr) {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_kurang' => 'required',
            'bulan' => 'nullable',
            'tahun' => 'nullable',
            'is_periode' => 'required',
            'keterangan' => 'required',
            'kode_keterangan' => 'nullable',
        ];

        $data = request()->validate($rules);

        if(request('is_periode') == 1){
            if(request('bulan') == null){
                $data['bulan'] = date('m');
            }
            if(request('tahun') == null){
                $data['tahun'] = date('Y');
            }
        }

        $kode = [];
        if(request('keterangan') == 1){
            foreach (request('kode_keterangan') as $k) {
                array_push( $kode, trim($k['nip']));
            }
    
            $data['kode_keterangan'] = implode(',', $kode);
        }
        if(request('keterangan') == 2){
            $data['kode_keterangan'] = $data['kode_keterangan']['kode_tingkat'];
        }
        if(request('keterangan') == 3){
            $data['kode_keterangan'] = $data['kode_keterangan']['kode_eselon'];
        }
        if(request('keterangan') == 4){
            $data['kode_keterangan'] = $data['kode_keterangan']['kode_skpd'];
        }
        if(request('keterangan') == 'semua'){
            $data['kode_keterangan'] = "";
        }

        $id = request('id');
        if($id){
            $cr = DaftarKurangPayroll::where('id', $id)->update($data);
        }else{
            $data['kode_perusahaan'] = generateUUID();
            $cr = DaftarKurangPayroll::create($data);
        }

        if ($cr) {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
