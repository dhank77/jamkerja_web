<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\LokasiResource;
use App\Http\Resources\Select\SelectResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Lokasi;
use App\Models\Master\LokasiDetail;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use App\Models\User;

class LokasiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $lokasi = Lokasi::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $lokasi->appends(request()->all());

        $lokasi = LokasiResource::collection($lokasi);

        return inertia('Master/Lokasi/Index', compact('lokasi'));
    }

    public function json()
    {
        $lokasi = Lokasi::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $lokasi = SelectResource::collection($lokasi);

        return response()->json($lokasi);
    }

    public function add()
    {
        $lokasi = new Lokasi();
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Master/Lokasi/Add', compact('lokasi', 'parent'));
    }

    public function edit(Lokasi $lokasi)
    {
        if ($lokasi->keterangan == '2') {
            $lokasiDetail = LokasiDetail::where('kode_lokasi', $lokasi->kode_lokasi)->get()->pluck('keterangan_id')->toArray();
            $lokasiDetail = $lokasiDetail ? $lokasiDetail[0] : [];
        }elseif ($lokasi->keterangan == '3') {
            $lokasiDetail = LokasiDetail::where('kode_lokasi', $lokasi->kode_lokasi)->get()->pluck('keterangan_id')->toArray();
            $lokasiDetail = $lokasiDetail ? Skpd::where('kode_skpd', $lokasiDetail[0])->first() : [];
            LokasiResource::withoutWrapping();
            $lokasiDetail = SelectResource::make($lokasiDetail);
        } else {
            $lokasiDetail = LokasiDetail::where('kode_lokasi', $lokasi->kode_lokasi)->get()->pluck('keterangan_id')->toArray();
            $lokasiDetail = User::whereIn('nip', $lokasiDetail)->orderBy('name')->get();
            LokasiResource::withoutWrapping();
            $lokasiDetail = SelectResource::collection($lokasiDetail);
        }
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        return inertia('Master/Lokasi/Add', compact('lokasi', 'parent', 'lokasiDetail'));
    }

    public function delete(Lokasi $lokasi)
    {
        $cr = $lokasi->delete();
        if ($cr) {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'values.kode_lokasi' => 'required',
            'values.nama' => 'required',
            'values.kode_shift' => 'required',
            'values.keterangan' => 'required',
            'kordinat.kordinat' => 'nullable',
            'kordinat.latitude' => 'nullable',
            'kordinat.longitude' => 'nullable',
            'kordinat.jarak' => 'nullable',
        ];

        if (!request('values.id')) {
            $cek = Lokasi::where('kode_lokasi', request('values.kode_lokasi'))->first();
            if ($cek) {
                return redirect(route('master.lokasi.index'))->with([
                    'type' => 'error',
                    'messages' => "Kode Lokasi Wajib Tidak Boleh Sama!"
                ]);
            }
        }

        $data = request()->validate($rules);
        $data = $data['values'];
        $data = array_merge($data, request('kordinat'));
        $detail = request('keterangan');
        if ($detail == "") {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'error',
                'messages' => "Data Wajib diisi!"
            ]);
        }

        $cr = Lokasi::updateOrCreate(['id' => request('values.id')], $data);
        if (request('values.id')) {
            LokasiDetail::where('kode_lokasi', $data['kode_lokasi'])->delete();
        }
        if ($data['keterangan'] == 1) {
            foreach ($detail as $d) {
                LokasiDetail::create([
                    'kode_lokasi' => $data['kode_lokasi'],
                    'keterangan_tipe' => $data['keterangan'],
                    'keterangan_id' => $d['nip']
                ]);
            }
        } elseif($data['keterangan'] == 2) {
            LokasiDetail::create([
                    'kode_lokasi' => $data['kode_lokasi'],
                    'keterangan_tipe' => $data['keterangan'],
                    'keterangan_id' => $detail['kode_tingkat']
                ]);
        } elseif($data['keterangan'] == 3) {
            LokasiDetail::create([
                    'kode_lokasi' => $data['kode_lokasi'],
                    'keterangan_tipe' => $data['keterangan'],
                    'keterangan_id' => $detail['kode_skpd']
                ]);
        }

        if ($cr) {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
}
