<?php

namespace App\Http\Controllers\Pengajuan;

use App\Exports\Laporan\PengajuanExport;
use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pengajuan\PengajuanSakit;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LaporanPengajuanController extends Controller
{
    public function index()
    {
        return inertia("Pengajuan/Laporan/Index");
    }

    public function download()
    {
        if (request("jenis_pengajuan") == "" || request("jenis_laporan") == "") {
            return redirect()->back()->with([
                "type" => 'error',
                "messages" => "Jenis pengajuan atau laporan wajib dipilih!"
            ]);
        }

        $role = role('opd');

        $jenis_pengajuan = request("jenis_pengajuan");
        $jenis_laporan = request("jenis_laporan");
        $xls = request("xls");
        $tanggal = request("tanggal") ?? date("Y-m-d");
        $bulan = request("bulan") ?? date("m");
        $tahun = request("tahun") ?? date("Y");
        $tanggal_mulai = request("tanggal_mulai") ?? date("Y-m-d");
        $tanggal_selesai = request("tanggal_selesai") ?? date("Y-m-d");

        if ($jenis_pengajuan == "cuti") {
            $model = "App\Models\Pegawai\DataPengajuanCuti";
        } elseif ($jenis_pengajuan == "sakit") {
            $model = "App\Models\Pengajuan\PengajuanSakit";
        } elseif ($jenis_pengajuan == "izin") {
            $model = "App\Models\Pengajuan\PengajuanIzin";
        } elseif ($jenis_pengajuan == "ijin") {
            $model = "App\Models\Pengajuan\PengajuanIjin";
        }

        $data = $model::with("user")
            ->when($jenis_laporan, function ($qr) use ($jenis_laporan, $tanggal, $bulan, $tahun, $tanggal_mulai, $tanggal_selesai) {
                if ($jenis_laporan == "harian") {
                    $qr->whereDate("tanggal_mulai", "<=", $tanggal)->whereDate("tanggal_selesai", ">=", $tanggal);
                } elseif ($jenis_laporan == "bulanan") {
                    $qr->whereMonth("tanggal_mulai", $bulan)->whereYear("tanggal_mulai", $tahun);
                } elseif ($jenis_laporan == "tahunan") {
                    $qr->whereYear("tanggal_mulai", $tahun);
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
                    $qr->whereBetween("tanggal_mulai", ["$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25"]);
                } elseif ($jenis_laporan == "periode_tertentu") {
                    $qr->whereBetween("tanggal_mulai", [$tanggal_mulai, $tanggal_selesai]);
                }
            })
            ->select("data_pengajuan_$jenis_pengajuan.*")
            ->leftJoin("users", "users.nip", "data_pengajuan_$jenis_pengajuan.nip")
            ->when($role, function ($qr) {
                $skpd = auth()->user()->kepala_divisi_id;

                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('kode_skpd', $skpd)
                        ->where('is_akhir', 1);
                });
            })
            ->get();

        if ($xls) {
            $date = date("YmdHis");
            return Excel::download(new PengajuanExport($data, $jenis_laporan, $tanggal, $bulan, $tahun, $tanggal_mulai, $tanggal_selesai, $xls, "laporan.pengajuan.$jenis_pengajuan-xls"), "$jenis_pengajuan-$jenis_laporan-$date.xlsx");
        } else {
            $pdf = PDF::loadView("laporan.pengajuan.$jenis_pengajuan", compact('data', 'jenis_laporan', 'tanggal', 'bulan', 'tahun', 'tanggal_mulai', 'tanggal_selesai', 'xls'))->setPaper('a4', 'landscape');
            return $pdf->stream();
        }
    }
}
