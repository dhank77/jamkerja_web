<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\TambahPayrollResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Tingkat;
use App\Models\Payroll\DaftarTambahPayroll;

class TambahPayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $tambah = DaftarTambahPayroll::latest()->where('kode_perusahaan', kp())->paginate($limit);

        $tambah->appends(request()->all());
        $tambah = TambahPayrollResource::collection($tambah);
        return inertia('Payroll/Tambah/Index', compact('tambah'));
    }

    public function add()
    {
        $tambah = new DaftarTambahPayroll();
        $parent = Tingkat::with(str_repeat('children.', 99))->where('kode_perusahaan', kp())->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Payroll/Tambah/Add', compact('tambah', 'parent'));
    }

    public function edit(DaftarTambahPayroll $tambah)
    {
        $parent = Tingkat::with(str_repeat('children.', 99))->where('kode_perusahaan', kp())->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Payroll/Tambah/Add', compact('tambah', 'parent'));
    }

    public function delete(DaftarTambahPayroll $tambah)
    {
        $cr = $tambah->delete();
        if ($cr) {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_tambah' => 'required',
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
            $cr = DaftarTambahPayroll::where('id', $id)->update($data);
        }else{
            $data['kode_perusahaan'] = generateUUID();
            $cr = DaftarTambahPayroll::create($data);
        }


        if ($cr) {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
}
