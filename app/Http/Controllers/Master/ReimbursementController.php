<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\ReimbursementResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Reimbursement;

class ReimbursementController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $reimbursement = Reimbursement::when($search, function($qr, $search){
                                $qr->where('nama', 'LIKE', "%$search%");
                            })
                            ->where('kode_perusahaan', kp())
                            ->paginate($limit);

        $reimbursement->appends(request()->all());

        $reimbursement = ReimbursementResource::collection($reimbursement);

        return inertia('Master/Reimbursement/Index', compact('reimbursement'));
    }

    public function json()
    {
        $reimbursement = Reimbursement::orderBy('nama')->where('kode_perusahaan', kp())->get();
        SelectResource::withoutWrapping();
        $reimbursement = SelectResource::collection($reimbursement);

        return response()->json($reimbursement);
    }

    public function add()
    {
        $reimbursement = new Reimbursement();
        return inertia('Master/Reimbursement/Add', compact('reimbursement'));
    }

    public function edit(Reimbursement $reimbursement)
    {
        return inertia('Master/Reimbursement/Add', compact('reimbursement'));
    }

    public function delete(Reimbursement $reimbursement)
    {
        $cr = $reimbursement->where('kode_perusahaan', kp())->delete();
        if ($cr) {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
        ];

        $data = request()->validate($rules);

        if(request('id')){
            $cr = Reimbursement::where('id', request('id'))->update($data);
        }else{
            $data['kode_reimbursement'] = generateUUID();
            $data['kode_perusahaan'] = kp();
            $cr = Reimbursement::create($data);
        }

        if ($cr) {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
