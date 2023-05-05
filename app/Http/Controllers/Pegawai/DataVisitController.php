<?php

namespace App\Http\Controllers\Pegawai;

use App\Exports\Laporan\LaporanVisitExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\DataVisitResource;
use App\Models\Pegawai\DataVisit;
use App\Models\User;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class DataVisitController extends Controller
{
    public function index()
    {
        $date = request('d') ?? date('Y-m-d');
        $end = request('e') ?? date('Y-m-d');
        if(strtotime($end) < strtotime($date)){
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => 'Tanggal Akhir tidak boleh lebih besar atau sama dengan tanggal awal!'
            ]);
        }
        $search = request('s');
        $kode = request('kode');
        $limit = request('limit') ?? 10;

        $end = date('Y-m-d', (strtotime($end) + (60 * 60 * 24)));

        $role = role('opd');

        $qr = DataVisit::selectRaw("data_visit.id as id, users.name as nama, users.nip as nip, data_visit.tanggal, data_visit.judul, data_visit.keterangan, data_visit.kordinat, data_visit.lokasi, data_visit.foto, data_visit.tanggal")
                        ->leftJoin('users', 'users.nip', 'data_visit.nip')
                        ->when($search, function ($qr, $search) {
                            $qr->where('data_visit.nip', 'LIKE', "%$search%")
                            ->orWhere('users.name', 'LIKE', "%$search%");
                        })
                        ->when($kode, function ($qr, $kode) {
                            $qr->join('riwayat_jabatan', function ($qt) use($kode) {
                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                    ->where('riwayat_jabatan.kode_kode', $kode)
                                    ->whereNull('riwayat_jabatan.deleted_at')
                                    ->where('riwayat_jabatan.is_akhir', 1);
                            });
                        })
                        ->when($role, function ($qr) {
                            $skpd = auth()->user()->kepala_divisi_id;
                    
                            $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                    ->where('riwayat_jabatan.kode_skpd', $skpd)
                                    ->whereNull('riwayat_jabatan.deleted_at')
                                    ->where('riwayat_jabatan.is_akhir', 1);
                            });
                        })
                        ->whereBetween('data_visit.tanggal', [$date, $end])
                        ->whereNull('users.deleted_at')
                        ->where('users.kode_perusahaan', kp())
                        ->paginate($limit);

        $qr->appends(request()->all());


        $visits = DataVisitResource::collection($qr)
                                        ->additional(['meta' => [
                                            's' => $search,
                                            'limit' => $limit,
                                            'date' => $date,
                                            'end' => $end,
                                        ]]);
        
        return inertia('Visit/Index', compact('visits'));
    }

    public function laporan()
    {
        return inertia("Visit/Laporan");
    }

    public function laporan_download()
    {
        $role = role('opd');

        $jenis_laporan = request("jenis_laporan");
        $xls = request("xls");
        $tanggal = request("tanggal") ?? date("Y-m-d");
        $bulan = request("bulan") ?? date("m");
        $tahun = request("tahun") ?? date("Y");
        $tanggal_mulai = request("tanggal_mulai") ?? date("Y-m-d");
        $tanggal_selesai = request("tanggal_selesai") ?? date("Y-m-d");

        $data = DataVisit::with("user")
            ->when($jenis_laporan, function ($qr) use ($jenis_laporan, $tanggal, $bulan, $tahun, $tanggal_mulai, $tanggal_selesai) {
                if ($jenis_laporan == "harian") {
                    $qr->whereDate("tanggal", $tanggal);
                } elseif ($jenis_laporan == "bulanan") {
                    $qr->whereMonth("tanggal", $bulan)->whereYear("tanggal", $tahun);
                } elseif ($jenis_laporan == "tahunan") {
                    $qr->whereYear("tanggal", $tahun);
                } elseif ($jenis_laporan == "periode") {
                    $bulanR = $bulan;
                    $tahunR = $tahun;
                    if ($bulan == 1) {
                        $bulaniM = 12;
                        $tahunIm = $tahun - 1;
                    } else {
                        $bulaniM = $bulan - 1;
                        $tahunIm = $tahun;
                    }
                    $qr->whereBetween("tanggal", ["$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25"]);
                } elseif ($jenis_laporan == "periode_tertentu") {
                    $qr->whereBetween("tanggal", [$tanggal_mulai, $tanggal_selesai]);
                }
            })
            ->leftJoin("users", "users.nip", "data_visit.nip")
            ->when($role, function ($qr) {
                $skpd = auth()->user()->kepala_divisi_id;

                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('kode_skpd', $skpd)
                        ->where('is_akhir', 1);
                });
            })
            ->where('users.kode_perusahaan', kp())
            ->get();

        if ($xls) {
            $date = date("YmdHis");
            return Excel::download(new LaporanVisitExport($data, $jenis_laporan, $tanggal, $bulan, $tahun, $tanggal_mulai, $tanggal_selesai, $xls, "laporan.visit.index-xls"), "kunjungan-$jenis_laporan-$date.xlsx");
        } else {
            $pdf = PDF::loadView("laporan.visit.index", compact('data', 'jenis_laporan', 'tanggal', 'bulan', 'tahun', 'tanggal_mulai', 'tanggal_selesai', 'xls'))->setPaper('a4', 'landscape');
            return $pdf->stream();
        }
    }

}
