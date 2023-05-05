<?php

namespace App\Http\Controllers\Pegawai;

use App\Exports\Laporan\LaporanDivisiExport;
use App\Exports\Laporan\LaporanPegawaiExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\DataPresensiResource;
use App\Models\Pegawai\DataPresensi;
use App\Models\Presensi\PresensiFree;
use App\Models\User;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class DataPresensiController extends Controller
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

        $qr = PresensiFree::selectRaw("presensi_free.id as id, users.name as nama, users.nip as nip, presensi_free.tanggal, presensi_free.rule_datang, presensi_free.jam_datang, presensi_free.rule_pulang, presensi_free.jam_pulang, presensi_free.jam_istirahat_mulai, presensi_free.jam_istirahat_selesai, presensi_free.created_at, presensi_free.image_datang, presensi_free.image_pulang")
                        ->leftJoin('users', 'users.nip', 'presensi_free.nip')
                        ->when($search, function ($qr, $search) {
                            $qr->where('presensi_free.nip', 'LIKE', "%$search%")
                            ->orWhere('users.name', 'LIKE', "%$search%");
                        })
                        ->when($kode, function ($qr, $kode) {
                            $qr->where('presensi_free.kode_skpd', $kode);
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
                        ->whereBetween('presensi_free.tanggal', [$date, $end])
                        ->where('users.kode_perusahaan', kp())
                        ->whereNull('users.deleted_at')
                        ->paginate($limit);

        $qr->appends(request()->all());


        $presensi = DataPresensiResource::collection($qr)
                                        ->additional(['meta' => [
                                            's' => $search,
                                            'limit' => $limit,
                                            'date' => $date,
                                            'end' => $end,
                                        ]]);
        
        return inertia('Presensi/Index', compact('presensi'));
    }

    public function laporan_pegawai()
    {
        return inertia('Presensi/LaporanPegawai');
    }

    public function laporan_pegawai_download()
    {
        $bulan = request('bulan') ?? date('m');
        $tahun = request('tahun') ?? date('Y');
        $nip = request('nip');
        $xl = request('xl');
        $role = role('opd');

        $pegawai = User::where('nip', $nip)
                        ->when($role, function ($qr) {
                            $skpd = auth()->user()->kepala_divisi_id;
                    
                            $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                    ->where('kode_skpd', $skpd)
                                    ->where('is_akhir', 1);
                            });
                        })
                        ->where('users.kode_perusahaan', kp())
                        ->first();

        if($xl){
            $date = date("YmdHis");
            return Excel::download(new LaporanPegawaiExport($bulan, $tahun, $xl, $pegawai), "pegawai-$nip-$date.xlsx");
            // return view('laporan.presensi.pegawai', compact('bulan', 'xl', 'tahun', 'pegawai'));
        }else{
            $pdf = PDF::loadView('laporan.presensi.pegawai', compact('bulan', 'xl', 'tahun', 'pegawai'))->setPaper('a4', 'potrait');
            return $pdf->stream();
        }
    }

    public function laporan_divisi()
    {
        return inertia('Presensi/LaporanDivisi');
    }

    public function laporan_divisi_download()
    {
        $bulan = request('bulan') ?? date('m');
        $tahun = request('tahun') ?? date('Y');
        $kode = request('kode');
        $xl = request('xl');
        $role = role('opd');

        $presensi = PresensiFree::where('kode_skpd', $kode)
                        ->where('users.kode_perusahaan', kp())
                        ->select('nip')
                        ->whereMonth('tanggal', $bulan)
                        ->groupBy('nip')
                        ->pluck('nip')
                        ->toArray();

        $pegawai = User::whereIn('nip', $presensi)
                        ->when($role, function ($qr) {
                            $skpd = auth()->user()->kepala_divisi_id;
                    
                            $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                    ->where('kode_skpd', $skpd)
                                    ->where('is_akhir', 1);
                            });
                        })
                        ->where('users.kode_perusahaan', kp())
                        ->get();

        if($xl){
            $date = date("YmdHis");
            return Excel::download(new LaporanDivisiExport($bulan, $tahun, $kode, $pegawai), "pegawai-$kode-$date.xlsx");
            // return view('laporan.presensi.divisi-xls', compact('bulan', 'tahun', 'pegawai', 'kode'));
        }else{
            $pdf = PDF::loadView('laporan.presensi.divisi', compact('bulan', 'tahun', 'pegawai', 'kode'))->setPaper('a4', 'landscape');
            return $pdf->stream();
        }
    }
}
