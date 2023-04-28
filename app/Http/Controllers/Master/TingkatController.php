<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\TingkatResource;
use App\Http\Resources\Select\SelectResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;

class TingkatController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $tingkat = Tingkat::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $tingkat->appends(request()->all());

        $tingkat = TingkatResource::collection($tingkat);

        return inertia('Master/Tingkat/Index', compact('tingkat'));
    }

    public function json($skpd = null)
    {
        $tingkat = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->when($skpd, function ($qr, $skpd) {
            $qr->where('kode_skpd', $skpd);
        })->orderBy('nama')->get();
        SelectTingkatResource::withoutWrapping();
        $tingkat = SelectTingkatResource::collection($tingkat);

        return response()->json($tingkat);
    }

    public function add()
    {
        $tingkat = new Tingkat();
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Master/Tingkat/Add', compact('tingkat', 'parent'));
    }

    public function edit(Tingkat $tingkat)
    {
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Master/Tingkat/Add', compact('tingkat', 'parent'));
    }

    public function delete(Tingkat $tingkat)
    {
        $cr = $tingkat->delete();
        if ($cr) {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'values.nama' => 'required',
            'values.kode_tingkat' => 'required',
            'values.kode_eselon' => 'required',
            'values.jenis_jabatan' => 'required',
            'values.kode_skpd' => 'required',
            'values.parent_id' => 'nullable',
            'values.gaji_pokok' => 'required',
            'values.tunjangan' => 'required',
        ];

        if (!request('values.id')) {
            $cek = Tingkat::where('kode_tingkat', request('values.kode_tingkat'))->first();
            if ($cek) {
                return redirect(route('master.tingkat.index'))->with([
                    'type' => 'error',
                    'messages' => "Kode Tingkat Wajib Tidak Boleh Sama!"
                ]);
            }
        }

        $data = request()->validate($rules);
        $data = $data['values'];
        $data = array_merge($data, request('kordinat'));
        $data['gaji_pokok'] = number_to_sql($data['gaji_pokok']);
        $data['tunjangan'] = number_to_sql($data['tunjangan']);

        if (request('values.id')) {
            $cr = Tingkat::where(['id' => request('values.id')])->update($data);
        } else {
            $cr = Tingkat::create($data);
        }


        if ($cr) {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function org()
    {
        $kode_skpd = request('kode_skpd') ?? Skpd::value("kode_skpd");
        $urlStorage = url("/storage");
        $urlPublic = url("/no-image.png");

        $data = [];
        $jabatan = Tingkat::where('tingkat.kode_skpd', $kode_skpd)
            ->where('tingkat.jenis_jabatan', 1)->orderBy('parent_id')->get();

        $nama_skpd = Skpd::where('kode_skpd', $kode_skpd)->value('nama');

        foreach ($jabatan as $jab) {
            if ($jab->parent_id != null) {
                array_push($data, [
                    $jab->parent_id,
                    $jab->kode_tingkat
                ]);
            }
        }

        $parent = Tingkat::selectRaw("tingkat.kode_tingkat as ids, tingkat.nama as title, IFNULL(users.name, '-') as name, IF(image is null, '$urlPublic', CONCAT('$urlStorage/', image)) as image")
            ->leftJoin('riwayat_jabatan', function ($qr) {
                $qr->on("riwayat_jabatan.kode_tingkat", "tingkat.kode_tingkat")
                    ->leftJoin("users", "users.nip", "riwayat_jabatan.nip")
                    ->where('riwayat_jabatan.is_akhir', 1);
            })
            ->where('tingkat.kode_skpd', $kode_skpd)
            ->orderBy('tingkat.parent_id')
            ->get()->makeHidden(['parent', 'parents'])->toArray();

        $send = [];
        foreach ($parent as $k => $p) {
            $p['id'] = $p['ids'];
            $p = array_map('strval', $p);
            if ($k == count($parent) - 1) {
                array_push($send, (object) $p);
            } else {
                array_push($send, (object) $p);
            }
        }
        // dd($send);
        return inertia("Master/Tingkat/Org", compact('parent', 'send', 'kode_skpd', 'data', 'nama_skpd'));
    }
}
