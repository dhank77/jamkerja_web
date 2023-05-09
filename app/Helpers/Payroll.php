<?php

use App\Jobs\ProcessWaNotif;
use App\Models\Master\Eselon;
use App\Models\Master\Payroll\AbsensiPermenit;
use App\Models\Master\Payroll\Lembur;
use App\Models\Master\Payroll\Tambahan;
use App\Models\Master\Payroll\Tunjangan;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use App\Models\Pegawai\RiwayatTunjangan;
use App\Models\User;

function persen_tambah($id)
{
    $exp = array_map('trim', explode(',', $id));
    $tambah = Tambahan::whereIn('kode_tambah', $exp)->get();

    if (in_array("1", $exp)) {
        $nama = "Gaji Pokok, ";
    } else {
        $nama = "";
    }
    foreach ($tambah as $k => $t) {
        if ($k != 0 && $nama != "") {
            $nama .= ", $t->nama";
        } else {
            $nama .= "$t->nama";
        }
    }


    return $nama;
}

function master_tunjangan($id)
{
    $exp = array_map('trim', explode(',', $id));
    $tambah = Tunjangan::whereIn('kode_tunjangan', $exp)->get();
    $nama = "";
    foreach ($tambah as $k => $t) {
        if ($k != 0 && $nama != "") {
            $nama .= " + $t->nama";
        } else {
            $nama .= "$t->nama";
        }
    }


    return $nama;
}

function keterangan($id)
{
    switch ($id) {
        case 'semua':
            return "Semua Pegawai";
            break;
        case '1':
            return "Pegawai Tertentu";
            break;
        case '2':
            return "Tingkat Jabatan";
            break;
        case '3':
            return "Level Jabatan";
            break;
        case '4':
            return "Divisi Kerja";
            break;

        default:
            return "Err";
            break;
    }
}

function detail_keterangan($keterangan, $kode_keterangan)
{
    if ($keterangan == "semua") {
        return " - ";
    }
    if ($keterangan == "1") {
        $exp = array_map('trim', explode(',', $kode_keterangan));
        $users = User::whereIn('nip', $exp)->select('name')->get();
        $send = "";
        foreach ($users as $k => $user) {
            if ($k == 0) {
                $send .= $user->name;
            } else {
                $send .= ", " . $user->name;
            }
        }
        return $send;
    }
    if ($keterangan == "2") {
        return Tingkat::where('kode_tingkat', $kode_keterangan)->value('nama');
    }
    if ($keterangan == "3") {
        return Eselon::where('kode_eselon', $kode_keterangan)->value('nama');
    }
    if ($keterangan == "4") {
        return Skpd::where('kode_skpd', $kode_keterangan)->value('nama');
    }

    return "Err";
}

function get_nilai_tunjangan($nip, $kode)
{
    return RiwayatTunjangan::with('tunjangan')
                    ->where('nip', $nip)
                    ->where('is_aktif', 1)
                    ->where('kode_tunjangan', $kode)
                    ->value('nilai');
}

function get_rule_lembur($jam)
{
    return Lembur::where('jam', $jam)->first();
}

function generate_payroll_nip($nip, $no_hp, $jabatan, $kode_payroll, $bulan, $tahun)
{
    $cek = DataPayroll::where([
                        'kode_payroll' => $kode_payroll,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'nip' => $nip,
                        'is_aktif' => 1,
                    ])->first();

    if($cek){
        return;
    }
    $total = 0;
    $total_penambahan = 0;
    $total_potongan = 0;
    $kode_tingkat = $jabatan?->kode_tingkat;
    $kode_level = $jabatan?->tingkat?->kode_eselon;
    $kode_skpd = $jabatan?->kode_skpd;
    $gapok = get_gapok($nip);
    if (!$gapok) {
        $gapok =  $jabatan?->tingkat?->gaji_pokok ?? 0;
    }
    $total += $gapok;

    $tunjangan_jabatan = get_nilai_tunjangan($nip, 2);
    if (!$tunjangan_jabatan) {
        $tunjangan_jabatan =  $jabatan?->tingkat?->tunjangan ?? 0;
    }
    $total += $tunjangan_jabatan;
    $total_penambahan += $tunjangan_jabatan;



    // Payroll Dasar Gapok
    DataPayroll::updateOrCreate(
        [
            'kode_perusahaan' => kp(),
            'kode_payroll' => $kode_payroll,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'nip' => $nip,
        ],
        [
            'kode_tingkat' => $kode_tingkat,
            'jabatan' => $jabatan?->tingkat?->nama,
            'divisi' => $jabatan?->skpd?->nama,
            'gaji_pokok' => $gapok,
            'tunjangan' => $tunjangan_jabatan,
        ]
    );

    // Tunjangan Wajib
    $tunjangan = get_tunjangan($nip);
    foreach ($tunjangan as $tunj) {
        $total += $tunj->nilai;
        $total_penambahan += $tunj->nilai;
        PayrollTambah::updateOrCreate(
            [
                'kode_perusahaan' => kp(),
                'kode_payroll' => $kode_payroll,
                'nip' => $nip,
                'kode_tambahan' => $tunj->kode_tunjangan,
            ],
            [
                'nilai' => $tunj->nilai,
                'keterangan' => $tunj?->tunjangan?->nama,
            ]
        );
    }

    // Potongan Wajib
    $potongan = get_potongan($nip);
    foreach ($potongan as $pot) {
        $satuan = $pot?->potongan?->satuan;
         if($satuan){
             if($satuan == 2){
                 $kode_persen = $pot?->potongan?->kode_persen;
                 $exp = explode(',', $kode_persen);
                 $nilai = 0;
                 foreach ($exp as $key => $e) {
                    if($e == 1){
                        $nilai += $gapok * $pot?->potongan?->nilai / 100;
                    }elseif($e == 2){
                        $nilai += $tunjangan_jabatan * $pot?->potongan?->nilai / 100;
                    }else{
                        $nilai_tunjangan = get_nilai_tunjangan($nip, $e);
                        $nilai += $nilai_tunjangan * $pot?->potongan?->nilai / 100;
                    }
                 }
             }else{
                 $nilai = $pot?->potongan?->nilai;
             }
         }else{
            $nilai = 0;
         }
         $total -= $nilai;
         $total_potongan += $nilai;
 
         PayrollKurang::updateOrCreate(
             [
                'kode_perusahaan' => kp(),
                 'kode_payroll' => $kode_payroll,
                 'nip' => $nip,
                 'kode_kurang' => $pot->kode_kurang,
             ],
             [
                 'nilai' => $nilai,
                 'keterangan' => $pot?->potongan?->nama,
             ]
         );
    }

    // Tunjangan Tidak Wajib
    $tunjangan_person = get_tunjangan_person($nip, $bulan, $tahun, $kode_tingkat, $kode_level, $kode_skpd);
    foreach ($tunjangan_person as $tunj) {
        $satuan = $tunj?->tambah?->satuan;
        if($satuan){
            if($satuan == 2){
                $kode_persen = $tunj?->tambah?->kode_persen;
                $exp = explode(',', $kode_persen);
                $nilai = 0;
                foreach ($exp as $key => $e) {
                    if($e == 1){
                        $nilai += $gapok * $tunj?->tambah?->nilai / 100;
                    }elseif($e == 2){
                        $nilai += $tunjangan_jabatan * $tunj?->tambah?->nilai / 100;
                    }else{
                        $nilai_tunjangan = get_nilai_tunjangan($nip, $e);
                        $nilai += $nilai_tunjangan * $tunj?->tambah?->nilai / 100;
                    }
                }
            }else{
                $nilai = $tunj?->tambah?->nilai;
            }
        }else{
            $nilai = 0;
        }

        $total += $nilai;
        $total_penambahan += $nilai;

        PayrollTambah::updateOrCreate(
            [
                'kode_perusahaan' => kp(),
                'kode_payroll' => $kode_payroll,
                'nip' => $nip,
                'kode_tambahan' => $tunj->kode_tambah,
            ],
            [
                'nilai' => $nilai,
                'keterangan' => $tunj?->tambah?->nama,
            ]
        );
    }

     // Potongan Tidak Wajib
     $potongan_person = get_potongan_person($nip, $bulan, $tahun, $kode_tingkat, $kode_level, $kode_skpd);
     foreach ($potongan_person as $pot) {
         $satuan = $pot?->kurang?->satuan;
         if($satuan){
             if($satuan == 2){
                 $kode_persen = $pot?->kurang?->kode_persen;
                 $exp = explode(',', $kode_persen);
                 $nilai = 0;
                 foreach ($exp as $key => $e) {
                    if($e == 1){
                        $nilai += $gapok * $pot?->kurang?->nilai / 100;
                    }elseif($e == 2){
                        $nilai += $tunjangan_jabatan * $pot?->kurang?->nilai / 100;
                    }else{
                        $nilai_tunjangan = get_nilai_tunjangan($nip, $e);
                        $nilai += $nilai_tunjangan * $pot?->kurang?->nilai / 100;
                    }
                 }
             }else{
                 $nilai = $pot?->kurang?->nilai;
             }
         }else{
            $nilai = 0;
         }
         $total -= $nilai;
         $total_potongan += $nilai;
 
         PayrollKurang::updateOrCreate(
             [
                'kode_perusahaan' => kp(),
                 'kode_payroll' => $kode_payroll,
                 'nip' => $nip,
                 'kode_kurang' => $pot->kode_kurang,
             ],
             [
                 'nilai' => $nilai,
                 'keterangan' => $pot?->kurang?->nama,
             ]
         );
     }

    //  Tunjangan Selamanya
    $tunjangan_selamanya = get_tunjangan_selamanya($nip, $kode_tingkat, $kode_level, $kode_skpd);
    foreach ($tunjangan_selamanya as $tunj) {
        $satuan = $tunj?->tambah?->satuan;
        if($satuan){
            if($satuan == 2){
                $kode_persen = $tunj?->tambah?->kode_persen;
                $exp = explode(',', $kode_persen);
                $nilai = 0;
                foreach ($exp as $key => $e) {
                    if($e == 1){
                        $nilai += $gapok * $tunj?->tambah?->nilai / 100;
                    }elseif($e == 2){
                        $nilai += $tunjangan_jabatan * $tunj?->tambah?->nilai / 100;
                    }else{
                        $nilai_tunjangan = get_nilai_tunjangan($nip, $e);
                        $nilai += $nilai_tunjangan * $tunj?->tambah?->nilai / 100;
                    }
                }
            }else{
                $nilai = $tunj?->tambah?->nilai;
            }
        }else{
            $nilai = 0;
        }

        $total += $nilai;
        $total_penambahan += $nilai;

        PayrollTambah::updateOrCreate(
            [
                'kode_perusahaan' => kp(),
                'kode_payroll' => $kode_payroll,
                'nip' => $nip,
                'kode_tambahan' => $tunj->kode_tambah,
            ],
            [
                'nilai' => $nilai,
                'keterangan' => $tunj?->tambah?->nama,
            ]
        );
    }

    // Potongan selamanya
    $potongan_selamanya = get_potongan_selamanya($nip, $bulan, $tahun, $kode_tingkat, $kode_level, $kode_skpd);
    foreach ($potongan_selamanya as $pot) {
        $satuan = $pot?->kurang?->satuan;
        if($satuan){
            if($satuan == 2){
                $kode_persen = $pot?->kurang?->kode_persen;
                $exp = explode(',', $kode_persen);
                $nilai = 0;
                foreach ($exp as $key => $e) {
                   if($e == 1){
                       $nilai += $gapok * $pot?->kurang?->nilai / 100;
                   }elseif($e == 2){
                       $nilai += $tunjangan_jabatan * $pot?->kurang?->nilai / 100;
                   }else{
                       $nilai_tunjangan = get_nilai_tunjangan($nip, $e);
                       $nilai += $nilai_tunjangan * $pot?->kurang?->nilai / 100;
                   }
                }
            }else{
                $nilai = $pot?->kurang?->nilai;
            }
        }else{
           $nilai = 0;
        }
        $total -= $nilai;
        $total_potongan += $nilai;

        PayrollKurang::updateOrCreate(
            [
                'kode_perusahaan' => kp(),
                'kode_payroll' => $kode_payroll,
                'nip' => $nip,
                'kode_kurang' => $pot->kode_kurang,
            ],
            [
                'nilai' => $nilai,
                'keterangan' => $pot?->kurang?->nama,
            ]
        );
    }

    //  Penambahan Lembur
    $data_lembur = get_lembur($nip, $bulan, $tahun);
    foreach ($data_lembur as $lembur) {
        $waktu_mulai = $lembur->tanggal . " " . ($lembur->jam_mulai);
        $waktu_selesai = $lembur->tanggal . " " . ($lembur->jam_selesai);

        $jam = hitung_jam_menit($waktu_mulai, $waktu_selesai);

        if($jam > 0){
            $nilai = 0;
            for ($i=1; $i <= $jam; $i++) { 
                $rule = get_rule_lembur($i);

                $exp = explode(',', $rule->kode_tunjangan);
                foreach ($exp as $key => $e) {
                    if($e == 1){
                        $nilai += $gapok * $lembur->pengali;
                    }elseif($e == 2){
                        $nilai += $tunjangan_jabatan * $lembur->pengali;
                    }else{
                        $nilai_tunjangan = get_nilai_tunjangan($nip, $e);
                        $nilai += $nilai_tunjangan * $lembur->pengali;
                    }
                }
            }
        }else{
            $nilai = 0;
        }

        $total += $nilai;
        $total_penambahan += $nilai;

        PayrollTambah::updateOrCreate(
            [
                'kode_perusahaan' => kp(),
                'kode_payroll' => $kode_payroll,
                'nip' => $nip,
                'kode_tambahan' => 'lembur-' . $lembur->tanggal,
            ],
            [
                'nilai' => $nilai,
                'keterangan' => "Lembur",
            ]
        );
    }

    // Potongan Telat & Cepat Pulang
    $presensi = kehadiran_free($nip, $bulan, $tahun);
    // Perhitungan berdasarkan potongan persumber gaji
    // $hari_kerja = $presensi['hari_kerja'];
    // $total_izin = $presensi['total_izin'];
    // $total_alfa = $presensi['total_alfa'];

    // $nilai_telat = 0;
    // $nilai_alpha = 0;
    // foreach ($presensi['total_telat_datang'] as $k => $telat) {
    //     $sumber = 0;
    //     $kode_tunjangan = explode(',', $telat->kode_tunjangan);
    //     foreach ($kode_tunjangan as $kt) {
    //         if($kt == 1){
    //             $sumber += $gapok;
    //         }elseif($kt == 2){
    //             $sumber += $tunjangan_jabatan;
    //         }else{
    //             $nilai_tunjangan = get_nilai_tunjangan($nip, $kt);
    //             $sumber += $nilai_tunjangan;
    //         }
    //     }

    //     $nilai_telat += $sumber * $telat->pengali / 100;
    // }

    // $nilai_telat_pulang = 0;
    // foreach ($presensi['total_telat_pulang'] as $telat) {
    //     $sumber = 0;
    //     $kode_tunjangan = explode(',', $telat->kode_tunjangan);
    //     foreach ($kode_tunjangan as $kt) {
    //         if($kt == 1){
    //             $sumber += $gapok;
    //         }elseif($kt == 2){
    //             $sumber += $tunjangan_jabatan;
    //         }else{
    //             $nilai_tunjangan = get_nilai_tunjangan($nip, $kt);
    //             $sumber += $nilai_tunjangan;
    //         }
    //     }

    //     $nilai_telat_pulang += $sumber * $telat->pengali / 100;
    // }

    // Perhitungan potongan permenit
    $ap = AbsensiPermenit::where('keterangan', 'permenit')->whereNull('kode_eselon')->first() ??  new AbsensiPermenit();
    if(!$ap){
        $ap = AbsensiPermenit::where('keterangan', 'permenit')->where('kode_eselon', $kode_level)->first();
    }

    $ac = AbsensiPermenit::where('keterangan', 'perceklok')->whereNull('kode_eselon')->first() ??  new AbsensiPermenit();
    if(!$ac){
        $ac = AbsensiPermenit::where('keterangan', 'perceklok')->where('kode_eselon', $kode_level)->first();
    }

    $potong_telat = $presensi['menit_total_telat_semua'] * $ap->potongan;
    $tidak_ceklok = $presensi['total_tidak_ceklok'] * $ac->potongan;
    $total_presensi = $potong_telat + $tidak_ceklok;

    if($total_presensi > 0){
        $total -= $total_presensi;
        $total_potongan += $total_presensi;
        PayrollKurang::updateOrCreate(
            [
                'kode_perusahaan' => kp(),
                'kode_payroll' => $kode_payroll,
                'nip' => $nip,
                'kode_kurang' => 'potongan-absensi-' . $bulan . $tahun,
            ],
            [
                'nilai' => $total_presensi,
                'keterangan' => "Potongan Presensi $bulan $tahun",
            ]
        );
    }

     DataPayroll::where([
            'kode_payroll' => $kode_payroll,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'nip' => $nip,
        ])->update([
            'total' => $total,
            'total_potongan' => $total_potongan,
            'total_penambahan' => $total_penambahan,
        ]);
 

    dispatch(new ProcessWaNotif($no_hp, 'Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!'));
}
