<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Device;
use App\Models\Pegawai\Imei;
use App\Models\Pegawai\RiwayatPotonganCuti;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $pegawai = User::role('pegawai')
            ->when($search, function ($qr, $search) {
                $qr->where('name', 'LIKE', "%$search%");
            })
            ->when($role, function ($qr) {
                $user = auth()->user()->jabatan_akhir;
                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                $skpd = '';
                if ($jabatan) {
                    $skpd = $jabatan->kode_skpd;
                }

                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('kode_skpd', $skpd)
                        ->where('is_akhir', 1);
                });
            })
            ->where('kode_perusahaan', auth()->user()->kode_perusahaan)
            ->paginate($limit);

        $pegawai->appends(request()->all());

        $pegawai = PegawaiResource::collection($pegawai);

        return inertia('Pegawai/Pegawai/Index', compact('pegawai'));
    }

    public function json()
    {
        $pegawai = User::role('pegawai')->orderBy('name')->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);

        return response()->json($pegawai);
    }

    public function json_skpd()
    {
        $skpd = request('skpd');

        $pegawai = User::role('pegawai')
            ->select('users.name', 'users.nip')
            ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
            ->leftJoin('tingkat', 'tingkat.kode_tingkat', 'riwayat_jabatan.kode_tingkat')
            ->where('riwayat_jabatan.is_akhir', 1)
            ->where('tingkat.kode_skpd', $skpd)
            ->orderBy('name')
            ->whereNull('riwayat_jabatan.deleted_at')
            ->where('kode_perusahaan', auth()->user()->kode_perusahaan)
            ->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);

        return response()->json($pegawai);
    }

    public function add()
    {
        $pegawai = new User();

        return inertia('Pegawai/Pegawai/Add', compact('pegawai'));
    }

    public function edit(User $pegawai)
    {
        return inertia('Pegawai/Pegawai/Add', compact('pegawai'));
    }

    public function detail(User $pegawai)
    {
        $pegawai->tlahir = tanggal_indo($pegawai->tanggal_lahir);
        return inertia('Pegawai/Pegawai/Detail', compact('pegawai'));
    }

    public function delete(User $pegawai)
    {
        $cr = $pegawai->delete();
        if ($cr) {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nik' => 'required',
            'name' => 'required',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'kode_status' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'kode_agama' => 'nullable',
            'kode_kawin' => 'nullable',
            'golongan_darah' => 'nullable',
            'email' => 'nullable',
            'alamat' => 'nullable',
            'alamat_ktp' => 'nullable',
            'id_pns' => 'nullable',
        ];

        if (!request('id')) {
            $rules['nik'] = 'required|unique:users,deleted_at,NULL';
        }
        
        
        $data = request()->validate($rules);
        
        if (!request('id')) {
            $data['nip'] = generateUUID();
            $data['kode_perusahaan'] = auth()->user()->kode_perusahaan;
            $data['password'] = password_hash(request('email'), PASSWORD_BCRYPT);
            $cr = User::create($data);
            $cr->assignRole('pegawai');
        } else {
            $cr = User::where('nip', request('nip'))->update($data);
        }

        if ($cr) {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function upload()
    {
        request()->validate([
            'file' => 'max:2048|mimes:jpg,jpeg,png',
        ]);

        $nip = request('nip');
        $cek = User::where('nip', $nip)->first();
        if (request()->file('file') && $cek) {
            if ($cek->image) {
                Storage::delete($cek->image);
            }
            $ext = request()->file('file')->getClientOriginalExtension();
            $file =  request()->file('file')->storeAs($nip, $nip . "-foto" . ".$ext");
            $cr = $cek->update(['image' => $file]);
            if ($file != "" && $cr) {
                return response()->json(['status' => TRUE, 'file' => $file]);
            } else {
                return response()->json(['status' => FALSE]);
            }
        } else {
            return response()->json(['status' => FALSE]);
        }
    }

    public function reset_pass(User $pegawai)
    {
        $cr = $pegawai->update(['password' => password_hash($pegawai->nip, PASSWORD_BCRYPT)]);

        if ($cr) {
            return redirect(route('pegawai.pegawai.detail', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil mereset, password baru adalah Nomor Pegawai!"
            ]);
        } else {
            return redirect(route('pegawai.pegawai.detail', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function reset_imei(User $pegawai)
    {
        Imei::where('nip', $pegawai->nip)->delete();
        Device::where('nip', $pegawai->nip)->delete();

        return redirect(route('pegawai.pegawai.detail', $pegawai->nip))->with([
            'type' => 'success',
            'messages' => "Berhasil, Imei berhasil direset!"
        ]);
    }

    public function json_cuti(User $pegawai)
    {
        $total = $pegawai->cuti_tahunan;
        $potongan = RiwayatPotonganCuti::where('nip', $pegawai->nip)->where('tahun', date('Y'))->get();
        foreach ($potongan as $p) {
            if($p->keterangan == 'potongan'){
                $total -= $p->hari;
            }else{
                $total += $p->hari;
            }
        }

        $send = [
            'cuti_tahunan' => $pegawai->cuti_tahunan,
            'potongan' => $potongan,
            'total' => $total,
        ];
        return response()->json($send);
    }

    public function cuti_update(User $pegawai)
    {
        $ct = request('cuti_tahunan');
        $pegawai->update(['cuti_tahunan' => $ct]);

        return redirect()->back()->with([
            'type' => 'success',
            'messages' => "Berhasil diperbaharui!"
        ]);
    }
}
