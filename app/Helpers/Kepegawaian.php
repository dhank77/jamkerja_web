<?php

use App\Models\Logs;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use App\Models\Payroll\DaftarKurangPayroll;
use App\Models\Payroll\DaftarTambahPayroll;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\Pegawai\RiwayatPotongan;
use App\Models\Pegawai\RiwayatTunjangan;
use App\Models\User;

function get_masa_kerja($tanggal, $singkat = false)
{
    $date = new DateTime($tanggal);
    $now = new DateTime(date('Y-m-d'));
    $interval = $now->diff($date);
    if($singkat == false){
        return "$interval->y Tahun $interval->m Bulan";
    }else{
        return "{$interval->y}T/{$interval->m}B";
    }
}

function tambah_log($target_nip, $model_type, $model_id, $action)
{

    $data = [
        'user_nip' => auth()->user()->nip,
        'target_nip' => $target_nip,
        'model_type' => $model_type,
        'model_id' => $model_id,
        'action' => $action,
    ];

    Logs::create($data);
}

function get_gapok($nip)
{
    return RiwayatKgb::where('nip', $nip)->where('is_akhir', 1)->value('gaji_pokok');
}

function get_tunjangan($nip)
{
    return RiwayatTunjangan::with('tunjangan')
                    ->where('nip', $nip)
                    ->where('is_aktif', 1)
                    ->select('nilai', 'kode_tunjangan')
                    ->get();
}

function get_potongan($nip)
{
    return RiwayatPotongan::with('potongan')
                    ->where('nip', $nip)
                    ->where('is_aktif', 1)
                    ->select('kode_kurang')
                    ->get();
}


function get_lembur($nip, $bulan, $tahun)
{
    return DataPengajuanLembur::where('nip', $nip)
                    ->where('status', 1)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get();
}

function count_lembur($nip, $tanggal_mulai, $tanggal_selesai)
{
    return DataPengajuanLembur::where('nip', $nip)
                    ->where('status', 1)
                    ->whereDate('tanggal', '<=',  $tanggal_mulai)
                    ->whereDate('tanggal',  '>=', $tanggal_selesai)
                    ->count();
}


function get_tunjangan_person($nip, $bulan, $tahun, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarTambahPayroll::with('tambah')->where('bulan', $bulan)->where('tahun', $tahun);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_tunjangan_selamanya($nip, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarTambahPayroll::with('tambah')->where('is_periode', 0);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_potongan_person($nip, $bulan, $tahun, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarKurangPayroll::with('kurang')->where('bulan', $bulan)->where('tahun', $tahun);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_potongan_selamanya($nip, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarKurangPayroll::with('kurang')->where('is_periode', 0);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_skpd($kode_skpd)
{
    return Skpd::where('kode_skpd', $kode_skpd)->value('nama');
}

function get_sk_jabatan_terlama($nip)
{
    return RiwayatJabatan::where("nip", $nip)->orderBy('tanggal_sk')->value('tanggal_sk');
}

function get_level_from_nip($nip)
{
    $kode_tingkat = RiwayatJabatan::where("nip", $nip)->where("is_akhir", 1)->value("kode_tingkat");
    if($kode_tingkat == ""){
        return "";
    }

    $tingkat = Tingkat::with("eselon")->where("kode_tingkat", $kode_tingkat)->first();
    if(!$tingkat){
        return "";
    }

    return optional($tingkat->eselon)->nama;
}

function get_kode_skpd($nip)
{
    $user = User::where('nip', $nip)->first();
    $jabatanAkhir = optional($user)->jabatan_akhir;
    if($jabatanAkhir){
        $jabatan = array_key_exists('0', $jabatanAkhir->toArray()) ? $jabatanAkhir[0] : null;
        if($jabatan){
           return $jabatan->kode_skpd; 
        }
    }

    return "";
}

function get_kode_perusahaan($nip)
{
    return User::where('nip', $nip)->value('kode_perusahaan');
}

function get_jabatan_from_nip($nip)
{
    return RiwayatJabatan::select("tingkat.nama")
                    ->leftJoin("tingkat", "tingkat.kode_tingkat", "riwayat_jabatan.kode_tingkat")
                    ->where("nip", $nip)->where("is_akhir", 1)->value("tingkat.nama");
}

function pegawai_berdasarkan_umur($umur)
{
    $tahun_terendah = date("Y-m-d", strtotime("-$umur[usia_terendah] years"));
    $tahun_tertinggi = date("Y-m-d", strtotime("-$umur[usia_tertinggi] years"));

    return User::role('pegawai')
                ->whereBetween('tanggal_lahir', [$tahun_tertinggi, $tahun_terendah])
                ->count();
}

function get_kode_level_by_nip($nip)
{
    return User::where('users.nip', $nip)
                ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
                ->where('riwayat_jabatan.is_akhir', 1)
                ->whereNull('riwayat_jabatan.deleted_at')
                ->leftJoin('tingkat', 'tingkat.kode_tingkat', 'riwayat_jabatan.kode_tingkat')
                ->whereNull('tingkat.deleted_at')
                ->value('tingkat.kode_eselon');
}

function get_nip_from_ktp($no_ktp)
{
    return User::where('nik', $no_ktp)->value('nip');
}