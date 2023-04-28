<?php

use App\Models\Master\HariLibur;
use App\Models\Master\JamKerjaStatis;
use App\Models\Master\JkdJadwal;
use App\Models\Master\JkdMaster;
use App\Models\Master\JksPegawai;
use App\Models\Master\Payroll\Absensi;
use App\Models\Master\Payroll\AbsensiPermenit;
use App\Models\Master\Shift;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use App\Models\Pegawai\RiwayatPotonganCuti;
use App\Models\Presensi\PresensiFree;
use App\Models\User;
use Symfony\Component\Mime\Part\DataPart;

function hari_kerja($bulan, $tahun, $nip = false)
{
    $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    $hari = 0;
    for ($i = 1; $i <= $number; $i++) {
        // Hari kerja
        $hari_angka = date("w", strtotime("$tahun-$bulan-$i"));

        if ($nip) {
            $jam = JksPegawai::where('nip', $nip)->first();
            if ($jam) {
                $day =  date("w", strtotime("$tahun-$bulan-$i"));
                $data = JamKerjaStatis::where('kode_jam_kerja', $jam->kode_jam_kerja)->where('hari', $day)->first();
                if ($data) {
                    // Hari Libur Nasional
                    $hari_libur = check_libur("$tahun-$bulan-$i");

                    if ($data->jam_datang != '00:00' && $data->jam_pulang != '00:00' && $hari_libur != true) {
                        $hari += 1;
                    }
                }
            } else {
                $jkd = JkdJadwal::where("nip", $nip)->where("tanggal", date("Y-m-d", strtotime("$tahun-$bulan-$i")))->first();
                if ($jkd) {
                    $data = JkdMaster::where('kode_jkd', $jkd->kode_jkd)->first();

                    if ($data && $data->jam_datang != '00:00' && $data->jam_pulang != '00:00') {
                        $hari += 1;
                    }
                }
            }
        }
    }

    return $hari;
}

function kehadiran($nip, $bulan, $tahun)
{

    $total_izin = 0;
    $whereNotIn = [];

    $perizinan = DataPengajuanCuti::where(function ($qr) use ($bulan, $tahun) {
        $qr->where(function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal_mulai', $bulan)
                ->whereYear("tanggal_mulai", $tahun);
        })->orWhere(function ($qw)  use ($bulan, $tahun) {
            $qw->whereMonth('tanggal_selesai', $bulan)
                ->whereYear("tanggal_selesai", $tahun);
        });
    })
        ->where('nip', $nip)
        ->where('status', 1)
        ->get();

    foreach ($perizinan as $key => $izin) {
        $tanggal = getBetweenDates($izin->tanggal_mulai, $izin->tanggal_selesai);
        foreach ($tanggal as $t) {
            $hari_angka = date("w", strtotime("$t"));
            $hari_libur = check_libur(date("Y-m-d", strtotime($t)));

            if ($hari_angka != 0 && $hari_angka != 6 && $hari_libur != true && in_array($t, $whereNotIn) == false) {
                array_push($whereNotIn, $t);
            }
        }
    }

    $total_izin = count($whereNotIn);

    if (count($whereNotIn) > 0) {
        $whereNotInString = arrayToString($whereNotIn);
    } else {
        $whereNotInString = false;
    }

    $kehadiran = DataPresensi::select('tanggal_datang', 'tanggal_istirahat', 'tanggal_pulang', 'created_at', 'kode_shift')
        ->whereMonth('created_at', $bulan)
        ->whereYear("created_at", $tahun)
        ->where('nip', $nip)
        ->when($whereNotInString, function ($qr, $whereNotInString) {
            $qr->whereRaw("DATE(created_at) NOT IN ($whereNotInString)");
        })
        ->get();

    $hari_kerja = hari_kerja($bulan, $tahun);
    $total_telat_datang = [];
    $total_telat_pulang = [];
    $total_alfa = 0;
    $absen_libur = 0;
    $tanggal_dulicate = [];
    $shift_id = "";
    $shift =  new Shift();
    foreach ($kehadiran as $hadir) {

        if ($shift_id != $hadir->kode_shift) {
            $shift = get_shift($hadir->kode_shift);
            $shift_id = $hadir->kode_shift;
        }

        $tanggal = date("Y-m-d", strtotime("$hadir->created_at"));
        if (!in_array($tanggal, $tanggal_dulicate)) {

            array_push($tanggal_dulicate, $tanggal);

            // Hari kerja
            $hari_angka = date("w", strtotime("$hadir->created_at"));

            // Hari Libur Nasional
            $hari_libur = check_libur(date("Y-m-d", strtotime($hadir->created_at)));
            if ($hari_angka == 0 || $hari_angka == 6 || $hari_libur == true) {
                $absen_libur += 1;
            }

            if ($hadir->tanggal_datang != "" || $hadir->tanggal_istirahat != "" || $hadir->tanggal_pulang != "") {
                if ($hadir->tanggal_datang != "") {
                    //Pengurangan Telat 
                    if (strtotime($hadir->tanggal_datang) >= strtotime(date("Y-m-d", strtotime($hadir->tanggal_datang)) . " " . $shift->jam_tepat_datang . ":59")) {
                        $dateTimeObject1 = date_create(date("Y-m-d", strtotime($hadir->tanggal_datang)) . " " . $shift->jam_tepat_datang . ":59");
                        $dateTimeObject2 = date_create($hadir->tanggal_datang);
                        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                        $telat_datang = $difference->h * 60;
                        $telat_datang += $difference->i;

                        array_push($total_telat_datang, perhitungan_persen_telat($telat_datang));
                    }
                } else {
                    array_push($total_telat_datang, perhitungan_persen_telat(255));
                }


                if ($hadir->tanggal_pulang != "") {
                    // Pengurangan Cepat Pulang
                    if (strtotime($hadir->tanggal_pulang) <= strtotime(date("Y-m-d", strtotime($hadir->tanggal_pulang)) . " " . $shift->jam_tepat_pulang . ":00")) {
                        $dateTimeObject1 = date_create(date("Y-m-d", strtotime($hadir->tanggal_pulang)) . " " . $shift->jam_tepat_pulang . ":00");
                        $dateTimeObject2 = date_create($hadir->tanggal_pulang);
                        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                        $telat_pulang = $difference->h * 60;
                        $telat_pulang += $difference->i;

                        array_push($total_telat_pulang, perhitungan_persen_telat($telat_pulang));
                    }
                } else {
                    array_push($total_telat_pulang, perhitungan_persen_telat(255));
                }
            } else {
                array_push($total_telat_datang, perhitungan_persen_telat(255));
                array_push($total_telat_pulang, perhitungan_persen_telat(255));
            }
        }
    }

    // Alfa
    if (count($tanggal_dulicate) < $hari_kerja) {
        $total_alfa = ($hari_kerja - count($tanggal_dulicate) - $absen_libur);
    }

    return [
        'hari_kerja' => ($hari_kerja),
        'total_izin' => ($total_izin),
        'total_alfa' => ($total_alfa - $total_izin),
        'total_akhir' => ($hari_kerja - $total_alfa + $total_izin / $hari_kerja * 100),
        'total_telat_datang' => ($total_telat_datang),
        'total_telat_pulang' => ($total_telat_pulang),
    ];
}

function kehadiran_free($nip, $bulan, $tahun)
{
    $bulanR = $bulan;
    $tahunR = $tahun;
    if ($bulan == 1) {
        $bulaniM = 12;
        $tahunIm = $tahun - 1;
    } else {
        $bulaniM = $bulan - 1;
        $tahunIm = $tahun;
    }

    $tanggal_mulai = "$tahunIm-$bulaniM-26";
    $tanggal_selesai = "$tahunR-$bulanR-25";

    $kehadiran = PresensiFree::whereDate('tanggal', '>=',  $tanggal_mulai)
                            ->whereDate('tanggal',  '<=', $tanggal_selesai)
                            ->where('nip', $nip)
                            ->get();

    $hari_kerja = hari_kerja($bulan, $tahun, $nip);
    $total_telat_datang = [];
    $total_telat_pulang = [];
    $total_telat_datang_permenit = "00:00:00";
    $total_pulang_cepat_permenit = "00:00:00";
    $total_lebih_istirahat_permenit = "00:00:00";
    $total_tidak_ceklok = 0;
    $total_alfa = 0;
    $absen_libur = 0;
    $tanggal_dulicate = [];

    $no_ceklok = [];
    foreach ($kehadiran as $hadir) {
        // Perhitungan kehadiran dan potongan permenit
        $tidak_ceklok_hari = 0;
        if ($hadir->jam_datang != "") {
            if (strtotime($hadir->jam_datang) >= strtotime($hadir->rule_datang . ":59")) {
                $datang = hitung_jam_menit_detik_dari_2_jam($hadir->rule_datang, $hadir->jam_datang);
                $total_telat_datang_permenit = menjumlahkan_menit($total_telat_datang_permenit, $datang);
            }
        } else {
            $tidak_ceklok_hari += 1;
        }

        if ($hadir->jam_pulang != "") {
            if (strtotime($hadir->jam_pulang) <= strtotime($hadir->rule_pulang . ":00")) {
                if (strtotime($hadir->jam_pulang) >= strtotime($hadir->rule_pulang . ":59")) {
                    $pulang = hitung_jam_menit_detik_dari_2_jam( $hadir->rule_pulang, $hadir->jam_pulang);
                    $total_pulang_cepat_permenit = menjumlahkan_menit($total_pulang_cepat_permenit, $pulang);
                }
            }
        } else {
            $tidak_ceklok_hari += 1;
        }

        if ($hadir->jam_istirahat_mulai != "") {
            if ($hadir->jam_istirahat_selesai != "") {
                $menit = hitung_menit($hadir->jam_istirahat_selesai, $hadir->jam_istirahat_mulai);
                if ($menit > $hadir->rule_istirahat) {
                    $istirahat = hitung_jam_menit_detik_dari_2_jam($hadir->jam_istirahat_selesai, $hadir->jam_istirahat_mulai);
                    $total_lebih_istirahat_permenit = menjumlahkan_menit($total_lebih_istirahat_permenit, $istirahat);
                }
            }
        } else {
            $tidak_ceklok_hari += 1;
        }

        if ($hadir->jam_istirahat_selesai == "") {
            $tidak_ceklok_hari += 1;
        }

        if($tidak_ceklok_hari < 4){
            $total_tidak_ceklok += $tidak_ceklok_hari;
        }

        

        array_push($no_ceklok, ['nilai' => $tidak_ceklok_hari, 'tanggal' => $hadir->tanggal]);
    }

    // dd($no_ceklok);

    // Alfa
    if (count($tanggal_dulicate) < $hari_kerja) {
        $total_alfa = ($hari_kerja - count($tanggal_dulicate) - $absen_libur);
    }

    $total_semua = "00:00:00";
    $total_semua = menjumlahkan_menit($total_semua, $total_telat_datang_permenit);
    $total_semua = menjumlahkan_menit($total_semua, $total_pulang_cepat_permenit);
    $total_semua = menjumlahkan_menit($total_semua, $total_lebih_istirahat_permenit);

    return [
        'hari_kerja' => ($hari_kerja),
        'total_alfa' => ($total_alfa),
        'total_akhir' =>  $hari_kerja > 0 ? (($hari_kerja - $total_alfa) / $hari_kerja * 100) : 0,
        'total_telat_datang' => ($total_telat_datang),
        'total_telat_pulang' => ($total_telat_pulang),
        'total_tidak_ceklok' => ($total_tidak_ceklok),
        'total_pulang_cepat_permenit' => ($total_pulang_cepat_permenit),
        'total_telat_datang_permenit' => ($total_telat_datang_permenit),
        'total_lebih_istirahat_permenit' => ($total_lebih_istirahat_permenit),
        'total_telat_semua' => ($total_semua),
        'menit_total_telat_semua' => jam_menit_detik_to_menit($total_semua),
    ];
}

function kehadiran_free_summary($bulan, $tahun)
{
    $bulanR = $bulan;
    $tahunR = $tahun;
    if ($bulan == 1) {
        $bulaniM = 12;
        $tahunIm = $tahun - 1;
    } else {
        $bulaniM = $bulan - 1;
        $tahunIm = $tahun;
    }

    $tanggal_mulai = "$tahunIm-$bulaniM-26";
    $tanggal_selesai = "$tahunR-$bulanR-25";

    $kehadiran = PresensiFree::whereDate('tanggal', '<=',  $tanggal_selesai)
                            ->whereDate('tanggal',  '>=', $tanggal_mulai)
                            // whereMonth('tanggal', $bulan)
                            // ->whereYear("tanggal", $tahun)
                            ->get();

    $tcm = 0;
    $tcp = 0;
    $tcb = 0;
    $tcab = 0;
    foreach ($kehadiran as $hadir) {
        if ($hadir->jam_datang == "") {
            $tcm += 1;
        }
        if ($hadir->jam_pulang == "") {
            $tcp += 1;
        }
        if ($hadir->jam_istirahat_mulai == "") {
            $tcb += 1;
        }
        if ($hadir->jam_istirahat_selesai == "") {
            $tcab += 1;
        }
    }

    return (array) [
        'tcm' => $tcm,
        'tcp' => $tcp,
        'tcb' => $tcb,
        'tcab' => $tcab,
    ];
}

function kehadiran_pegawai($tanggal, $nip)
{
    $data = DataPresensi::whereDate('created_at', $tanggal)->where('nip', $nip)->first();
    return $data;
}

function kehadiran_pegawai_free($tanggal, $nip)
{
    $data = PresensiFree::whereDate('tanggal', $tanggal)->where('nip', $nip)->first() ?? new PresensiFree();
    return $data;
}

function get_shift($kode_shift)
{
    return Shift::where('kode_shift', $kode_shift)->first();
}

function check_libur($tanggal)
{
    $libur = HariLibur::where('tanggal_mulai', '<=', $tanggal)->where('tanggal_selesai', '>=', $tanggal)->count();
    if ($libur > 0) {
        return true;
    } else {
        return false;
    }
}

function check_libur_master($tanggal, $nip, $status)
{
    if ($status == null) {
        $jam = JksPegawai::where('nip', $nip)->first();
        if ($jam) {
            $day =  date("w", strtotime($tanggal));
            $jks = JamKerjaStatis::where('kode_jam_kerja', $jam->kode_jam_kerja)->where('hari', $day)->first();

            if ($jks->jam_datang == "00:00" && $jks->jam_pulang == "00:00") {
                return true;
            }
        }

        $jkd = JkdJadwal::where('tanggal', $tanggal)->where('nip', $nip)->where('kode_jkd', 'L')->value('nip');
        if ($jkd) {
            return true;
        }
    } elseif ($status == 'statis') {
        $jam = JksPegawai::where('nip', $nip)->first();
        if ($jam) {
            $day =  date("w", strtotime($tanggal));
            $jks = JamKerjaStatis::where('kode_jam_kerja', $jam->kode_jam_kerja)->where('hari', $day)->first();

            if ($jks->jam_datang == "00:00" && $jks->jam_pulang == "00:00") {
                return true;
            }
        }
    } elseif ($status == 'dinamis') {
        return JkdJadwal::where('tanggal', $tanggal)->where('nip', $nip)->where('kode_jkd', 'L')->value('nip') ? true : false;
    }

    return false;
}

function perhitungan_persen_telat($menit, $keterangan = 1)
{
    return Absensi::select('pengali', 'kode_tunjangan')->where('menit', '<=', $menit)->where('keterangan', $keterangan)->first();
}

function get_jadwal($kode_jam_kerja)
{
    return JamKerjaStatis::where('kode_jam_kerja', $kode_jam_kerja)->orderBy('hari')->get();
}

function jumlah_pegawai_jks($kode_jam_kerja)
{
    return JksPegawai::where('kode_jam_kerja', $kode_jam_kerja)->count();
}

function jam_kerja_nip($nip)
{
    $jam = JksPegawai::where('nip', $nip)->first();
    if ($jam) {
        $day =  date("w");
        $send = JamKerjaStatis::where('kode_jam_kerja', $jam->kode_jam_kerja)->where('hari', $day)->first();
        $send->status = "statis";
        return $send;
    }

    $jkd = JkdJadwal::where("nip", $nip)->where("tanggal", date("Y-m-d"))->first();
    if ($jkd) {
        $send = JkdMaster::where('kode_jkd', $jkd->kode_jkd)->first();
        $send->status = "dinamis";
        return $send;
    }

    $jkd = JkdJadwal::where("nip", $nip)->where("tanggal", date("Y-m-d", strtotime('-1 days')))->first();
    if ($jkd) {
        $send = JkdMaster::where('kode_jkd', $jkd->kode_jkd)->first();
        $send->status = "dinamis";
        return $send;
    }

    return null;
}

function menit_dari_2jam($jam1, $jam2)
{
    if ($jam1 != "" && $jam2 != "") {
        $start = strtotime($jam1);
        $end = strtotime($jam2);
        if ($start > $end) {
            return 0;
        } else {
            $mins = ($end - $start) / 60;
            return round($mins);
        }
    }

    return 0;
}

function perhitungan_sebulan($nip, $bulan, $tahun)
{
    $presensi = PresensiFree::where("nip", $nip)
        ->whereMonth("tanggal", $bulan)
        ->whereYear("tanggal", $tahun)
        ->get();

    $telat = 0;
    $cepat = 0;
    foreach ($presensi as $p) {
        $telat += menit_dari_2jam($p->rule_datang, $p->jam_datang);
        $cepat += menit_dari_2jam($p->jam_pulang, $p->rule_pulang);
    }

    return [
        'telat' => $telat,
        'cepat' => $cepat,
    ];
}

function perhitungan_cuti($nip, $bulan, $tahun, $model)
{
    $cuti = $model::where(function ($qr) use ($bulan, $tahun) {
        $qr->where(function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal_mulai', $bulan)
                ->whereYear("tanggal_mulai", $tahun);
        })->orWhere(function ($qw)  use ($bulan, $tahun) {
            $qw->whereMonth('tanggal_selesai', $bulan)
                ->whereYear("tanggal_selesai", $tahun);
        })->orWhere(function ($qw)  use ($bulan, $tahun) {
            $date = strtotime("$tahun-$bulan-" . date("d"));
            $qw->whereRaw("UNIX_TIMESTAMP(tanggal_mulai) <= $date && UNIX_TIMESTAMP(tanggal_selesai) >= $date");
        });
    })
        ->where('nip', $nip)
        ->where("status", 1)
        ->get();

    $whereNotIn = [];
    foreach ($cuti as $key => $izin) {

        $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $batas_bulan = strtotime("$tahun-$bulan-$number");
        $awal_bulan = strtotime("$tahun-$bulan-1");
        $tanggal = getBetweenDates($izin->tanggal_mulai, $izin->tanggal_selesai);
        foreach ($tanggal as $t) {
            $tanggal_time = strtotime($t);

            if (in_array($t, $whereNotIn) == false && $tanggal_time <= $batas_bulan && $tanggal_time >= $awal_bulan) {
                array_push($whereNotIn, $t);
            }
        }
    }

    return count($whereNotIn);
}

function perhitungan_cuti_tahunan($nip, $tahun)
{
    $pengajuan = DataPengajuanCuti::where('nip', $nip)
        ->where('kode_cuti', 19)
        ->where('status', 1)
        ->where(function ($qr) use ($tahun) {
            $qr->whereYear("tanggal_mulai", $tahun)
                ->orWhereYear("tanggal_selesai", $tahun);
        })
        ->get();

    $hari = 0;
    $tanggalAll = [];
    $tanggal_mulai_selesai = "";
    foreach ($pengajuan as $k => $p) {
        $tanggal = get_between_dates($p->tanggal_mulai, $p->tanggal_selesai);
        foreach ($tanggal as $t) {
            $akhirTahun = strtotime("$tahun-12-31");
            $tgl = strtotime($t);
            if ($tgl <= $akhirTahun) {
                array_push($tanggalAll, date_indo($t));
                $hari += 1;
            }
        }
        if ($k == 0) {
            $tanggal_mulai_selesai .= date_indo($p->tanggal_mulai) . "-" . date_indo($p->tanggal_selesai);
        } else {
            $tanggal_mulai_selesai .= ", " . date_indo($p->tanggal_mulai) . "-" . date_indo($p->tanggal_selesai);
        }
    }

    $total = User::where('nip', $nip)->value('cuti_tahunan');
    $potongan = RiwayatPotonganCuti::where('nip', $nip)->where('tahun', date('Y'))->get();
    foreach ($potongan as $p) {
        if($p->keterangan == 'potongan'){
            $total -= $p->hari;
        }else{
            $total += $p->hari;
        }
    }

    return [
        'total' => $total,
        'hari' => $hari,
        'tanggal' => $tanggalAll,
        'tanggal_mulai_selesai' => $tanggal_mulai_selesai,
    ];
}

function get_jumlah_pengajuan($model, $nip, $tahun, $bulan = null)
{
    return $model::where("nip", $nip)
        ->whereYear("tanggal_mulai", "<=", $tahun)
        ->whereYear("tanggal_selesai", ">=", $tahun)
        ->when($bulan, function ($qr, $bulan) {
            $qr->whereMonth("tanggal_mulai", "<=", $bulan)
                ->whereMonth("tanggal_mulai", ">=", $bulan);
        })
        ->count();
}

function pengajuan_pegawai($model, $tanggal, $nip)
{
    return $model::where("nip", $nip)
        ->whereDate("tanggal_mulai", "<=", $tanggal)
        ->whereDate("tanggal_selesai", ">=", $tanggal)
        ->where('status', 1)
        ->value('nip');
}

function kunjungan_pegawai($tanggal, $nip)
{
    return DataVisit::where("nip", $nip)
        ->whereDate("tanggal", $tanggal)
        ->value('judul');
}

function total_pengajuan_cutoff($model, $tanggal_mulai, $tanggal_selesai, $nip)
{
    return $model::where("nip", $nip)
        ->whereBetween("tanggal_mulai", [$tanggal_mulai, $tanggal_selesai])
        ->where('status', 1)
        ->count();
}

function get_presensi_ijin($nip, $tanggal)
{
    return PresensiFree::where("tanggal", $tanggal)->where("nip", $nip)->first() ?? new PresensiFree();
}

function menjumlahkan_menit($waktu1, $waktu2)
{
    if ($waktu2 != "-") {
        // ambil jam   
        $j1 = (int) substr($waktu1, 0, 2);
        $j2 = (int) substr($waktu2, 0, 2);

        // ambil menit 
        $m1 = (int) substr($waktu1, 3, 2);
        $m2 = (int) substr($waktu2, 3, 2);

        // ambil detik 
        $d1 = (int) substr($waktu1, 6, 2);
        $d2 = (int) substr($waktu2, 6, 2);

        $jt = $j1 + $j2;
        $mt = $m1 + $m2;
        if ($mt > 60) {
            $mts = $mt % 60;
            $mtt = ($mt - $mts) / 60;
            $jt = $jt + $mtt;
            $mt = $mts;
        }
        $dt = $d1 + $d2;
        if ($dt > 60) {
            $dts = $dt % 60;
            $dtt = ($dt - $dts) / 60;
            $mt = $mt + $dtt;
            $dt = $dts;
        }
        $jt = sprintf("%02d", $jt);
        $mt = sprintf("%02d", $mt);
        $dt = sprintf("%02d", $dt);


        if ("$jt:$mt:$dt" == "00:00:00") {
            return "-";
        } else {
            return "$jt:$mt:$dt";
        }
    } else {
        if ($waktu1 == "00:00:00") {
            return "-";
        } else {
            return $waktu1;
        }
    }
}

function get_potongan_kode($nip, $bulan, $tahun, $kode)
{
    return DataPayroll::where('nip', $nip)
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->leftJoin('payroll_kurang', 'payroll_kurang.kode_payroll', 'data_payroll.kode_payroll')
                        ->where('kode_kurang', $kode)
                        ->first();
}

function get_potongan_absensi($nip, $bulan, $tahun)
{
    $presensi = kehadiran_free($nip, $bulan, $tahun);
    // dd($presensi);
    // Perhitungan potongan permenit
    $ap = AbsensiPermenit::where('keterangan', 'permenit')->whereNull('kode_eselon')->first() ??  false;
    $ac = AbsensiPermenit::where('keterangan', 'perceklok')->whereNull('kode_eselon')->first() ??  false;
    if(!$ap || !$ac){
        $kode_level = get_kode_level_by_nip($nip);
    }
    if(!$ap){
        $ap = AbsensiPermenit::where('keterangan', 'permenit')->where('kode_eselon', $kode_level)->first() ?? new AbsensiPermenit();
    }
    
    if(!$ac){
        $ac = AbsensiPermenit::where('keterangan', 'perceklok')->where('kode_eselon', $kode_level)->first() ?? new AbsensiPermenit();
    }

    

    $potong_telat = $presensi['menit_total_telat_semua'] * $ap->potongan;
    $tidak_ceklok = $presensi['total_tidak_ceklok'] * $ac->potongan;
    $total_presensi = $potong_telat + $tidak_ceklok;

    return [
        'total' => $total_presensi,
        'ceklok' => $tidak_ceklok,
        'telat' => $potong_telat,
    ];
}
