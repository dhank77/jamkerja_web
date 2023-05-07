<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\User;

class ManagerController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $users = User::role('opd')
            ->when($search, function ($qr, $search) {
                $qr->where('name', 'LIKE', "%$search%");
            })
            ->where('kode_perusahaan', kp())
            ->orderBy('name')
            ->paginate($limit);

        $users->appends(request()->all());

        $users = PegawaiResource::collection($users);
        return inertia('Users/Manager/Index', compact('users'));
    }

    public function add()
    {
        $opd = User::role('opd')->pluck('id')->toArray();

        $users = User::role('pegawai')
                    ->orderBy('name')
                    ->where('kode_perusahaan', kp())
                    ->whereNotIn('id', $opd)
                    ->get();
        SelectResource::withoutWrapping();
        $users = SelectResource::collection($users);

        return inertia('Users/Manager/Add', compact('users'));
    }

    public function store()
    {
        $pegawai = request()->all();

        if(count($pegawai) > 0){

            foreach ($pegawai as $p) {
                $user = User::where('nip', $p['value'])->where('kode_perusahaan', kp())->first();
                $jabatanAkhir = optional($user)->jabatan_akhir;
                $jabatan = array_key_exists('0', $jabatanAkhir->toArray()) ? $jabatanAkhir[0] : null;
                $skpd = '';
                if($jabatan){
                    $skpd = $jabatan->kode_skpd; 
                    $user->update(["kepala_divisi_id" => $skpd]);
                    $user->assignRole('opd');
                }
                
            }

            return redirect(route('users.manager.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, Menambahkan Data!"
            ]);
        }

        return redirect(route('users.manager.index'))->with([
            'type' => 'error',
            'messages' => "Gagal!"
        ]);
    }

    public function delete(User $manager)
    {
        $manager->removeRole('opd');
        return redirect()->back()->with([
            'type' => 'success',
            'messages' => 'Berhasil dihapus sebagai Kepala Divisi!'
        ]);
    }
}
