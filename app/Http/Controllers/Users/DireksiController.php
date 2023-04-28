<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\User;

class DireksiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $users = User::role('owner')
            ->when($search, function ($qr, $search) {
                $qr->where('name', 'LIKE', "%$search%");
            })
            ->orderBy('name')
            ->paginate($limit);

        $users->appends(request()->all());

        $users = PegawaiResource::collection($users);
        return inertia('Users/Hrd/Index', compact('users'));
    }

    public function add()
    {
        $owner = User::role('owner')->pluck('id')->toArray();

        $users = User::role('pegawai')
                    ->orderBy('name')
                    ->whereNotIn('id', $owner)
                    ->get();
        SelectResource::withoutWrapping();
        $users = SelectResource::collection($users);

        return inertia('Users/Hrd/Add', compact('users'));
    }

    public function store()
    {
        $pegawai = request()->all();

        if(count($pegawai) > 0){

            foreach ($pegawai as $p) {
                $user = User::where('nip', $p['value'])->first();
                $user->assignRole('owner');
            }

            return redirect(route('users.hrd.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, Menambahkan Data!"
            ]);
        }

        return redirect(route('users.hrd.index'))->with([
            'type' => 'error',
            'messages' => "Gagal!"
        ]);
    }

    public function delete(User $hrd)
    {
        $hrd->removeRole('owner');
        return redirect()->back()->with([
            'type' => 'success',
            'messages' => 'Berhasil dihapus sebagai Direksi!'
        ]);
    }
}
