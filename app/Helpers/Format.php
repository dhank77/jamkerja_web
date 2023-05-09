<?php

use App\Models\Master\Tingkat;
use App\Models\Pengumuman;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function role($string)
{
    $arrayRole = auth()->user()->getRoleNames()->toArray();
    if (in_array($string, $arrayRole)) {
        return true;
    } else {
        return false;
    }
}

function role_only($role)
{
    $roles = auth()->user()->getRoleNames()->toArray();

    if (in_array($role, $roles) && count($roles) == 1) {
        return true;
    } else {
        return false;
    }
}

function storage($file)
{
    return $file ? asset("storage/$file") : asset("no-image.png");
}

function storageNull($file)
{
    return $file ? asset("storage/$file") : "";
}

function storageTest($file)
{
    return $file ? "https://sbcjombang.com/storage/$file" : "";
}

function get_day_from_date($date)
{
    return date("m", strtotime($date));
}

function jenis_jabatan($kode)
{
    switch ($kode) {
        case '1':
            return "Struktural";
            break;
        case '2':
            return "Fungsional";
            break;
        case '4':
            return "Pelaksana";
            break;

        default:
            return "Err";
            break;
    }
}

function status($kode)
{
    switch ($kode) {
        case '0':
            return "Diajukan";
            break;
        case '1':
            return "Diterima";
            break;
        case '2':
            return "Ditolak";
            break;

        default:
            return "Err";
            break;
    }
}

function status_web($kode)
{
    switch ($kode) {
        case '0':
            return "<span class='badge badge-primary'>Diajukan</span>";
            break;
        case '1':
            return "<span class='badge badge-success'>Diterima</span>";
            break;
        case '2':
            return "<span class='badge badge-danger'>Ditolak</span>";
            break;
        case '3':
            return "<span class='badge badge-warning'>Dibatalkan</span>";
            break;

        default:
            return "Err";
            break;
    }
}

function status_tugas($kode)
{
    switch ($kode) {
        case '0':
            return "<span class='badge badge-primary'>Ditugaskan</span>";
            break;
        case '1':
            return "<span class='badge badge-success'>Progress</span>";
            break;
        case '2':
            return "<span class='badge badge-danger'>Ditolak</span>";
            break;
        case '3':
            return "<span class='badge badge-warning'>Selesai</span>";
            break;

        default:
            return "Err";
            break;
    }
}

function is_aktif($kode)
{
    switch ($kode) {
        case '0':
            return "<span class='badge badge-danger'>Tidak Aktif</span>";
            break;
        case '1':
            return "<span class='badge badge-success'>Aktif</span>";
            break;

        default:
            return "Err";
            break;
    }
}


function limitdecimal($number, $limit = 2)
{
    return number_format((float)$number, $limit, '.', '');
}

function pembulatan($number, $limit = -2)
{
    return round($number, $limit);
}

function number_to_sql($num)
{
    if ($num == '') {
        return 0;
    }
    $exp = explode('.', $num);
    if (strlen($exp[count($exp) - 1]) == 2 && strlen($num) > 2) {
        $num = substr($num, 0, -3);
    }
    $delDot = str_replace('.', '', $num);
    $delCom = str_replace(',', '.', $delDot);
    return (float) $delCom;
}

function number_indo($num, $des = 0)
{
    if ($des == 0) {
        if ($num <= 100) {
            $des = 2;
        }
    }

    return number_format($num, $des, ',', '.');
}

function tanggal_indo($date)
{
    if ($date != "") {
        $tgl = date('d', strtotime($date));
        $bulan = date('m', strtotime($date));
        $tahun = date('Y', strtotime($date));

        return $tgl . " " . bulan($bulan) . " " . $tahun;
    } else {
        return " - ";
    }
}

function date_indo($date)
{
    if ($date != "") {
        $tgl = date('d/m/Y', strtotime($date));

        return $tgl;
    } else {
        return " - ";
    }
}

function getAgama()
{
    return [
        'islam',
        'protestan',
        'katholik',
        'hindu',
        'budha',
        'konghucu',
        'lainnya',
    ];
}

function hari_kecil($hari)
{
    switch ($hari) {
        case 1:
            return "Sen";
            break;
        case 2:
            return "Sel";
            break;
        case 3:
            return "Rab";
            break;
        case 4:
            return "Kam";
            break;
        case 5:
            return "Jum";
            break;
        case 6:
            return "Sab";
            break;
        case 0:
            return "Ahd";
            break;
    }
}

function hari($hari)
{
    switch ($hari) {
        case 1:
            return "Senin";
            break;
        case 2:
            return "Selasa";
            break;
        case 3:
            return "Rabu";
            break;
        case 4:
            return "Kamis";
            break;
        case 5:
            return "Jumat";
            break;
        case 6:
            return "Sabtu";
            break;
        case 0:
            return "Minggu";
            break;
    }
}

function bulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function terbilang($x)
{
    $abil = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    if ($x < 12)
        return " " . $abil[$x];
    elseif ($x < 20)
        return Terbilang($x - 10) . " Belas";
    elseif ($x < 100)
        return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
    elseif ($x < 200)
        return " Seratus" . Terbilang($x - 100);
    elseif ($x < 1000)
        return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
    elseif ($x < 2000)
        return " Seribu" . Terbilang($x - 1000);
    elseif ($x < 1000000)
        return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
    elseif ($x < 1000000000)
        return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
    elseif ($x < 1000000000000)
        return Terbilang($x / 1000000000) . " Milyar" . Terbilang($x % 1000000000);
    elseif ($x < 1000000000000000)
        return Terbilang($x / 1000000000000) . " Triliyun" . Terbilang($x % 1000000000000);
}

function hitung_tahun($start, $end)
{
    $date = new DateTime($start);
    $now = new DateTime($end);
    $interval = $now->diff($date);
    return $interval->y;
}

function hitung_jam_menit($start, $end)
{
    $date = new DateTime($start);
    $now = new DateTime($end);
    $interval = $now->diff($date);
    $jam = $interval->h;
    if ($interval->i > 30) {
        $jam += 1;
    }
    return $jam;
}

function hitung_jam_menit_detik_dari_2_jam($start, $end)
{
    $date = new DateTime(date("Y-m-d") . " " . $start);
    $now = new DateTime(date("Y-m-d") . " " . $end);
    if ($start > $end) {
        return "-";
    }
    $interval = $now->diff($date);
    $jam = $interval->h;
    $menit = $interval->i;
    $detik = $interval->s;
    $hasil =  date("H:i:s", strtotime(date("Y-m-d") . " " . "$jam:$menit:$detik"));
    return $hasil == "00:00:00" ? "-" : $hasil;
}

function get_jam($tanggal)
{
    return $tanggal ? date("H:i", strtotime($tanggal)) : "-";
}

function menit_to_jam_menit_detik($menit)
{
    $jam = "00";
    $menit_ = "00";
    if ($menit > 0) {
        if ($menit > 60) {
            $jam = round($menit / 60);
            $menit_ = $menit % 60;
            return date("H:i:s", strtotime(date("Y-m-d") . " " . "$jam:$menit_:00"));
        } else {
            return date("H:i:s", strtotime(date("Y-m-d") . " " . "00:$menit:00"));
        }
    } else {
        return "-";
    }
}

function jam_menit_detik_to_menit($jam)
{
    $jam_sub = (int) substr($jam, 0, 2);
    $menit_sub = (int) substr($jam, 3, 2);

    return ($jam_sub * 60) + $menit_sub;
}

function hitung_menit($mulai, $selesai)
{
    $dateTimeObject1 = date_create(date("Y-m-d") . " " . $mulai);
    $dateTimeObject2 = date_create(date("Y-m-d") . " " . $selesai);
    $difference = date_diff($dateTimeObject1, $dateTimeObject2);
    $hasil = $difference->h * 60;
    $hasil += $difference->i;

    return $hasil;
}

function getBetweenDates($startDate, $endDate)
{

    $rangArray = [];
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}

function dayBetween2Days($start, $end = null)
{
    $now = $end ? strtotime($end . "23:59:59") : strtotime(date("Y-m-d") . " 23:59:59");
    $your_date = strtotime($start . " 00:00:01");
    $datediff = $now - $your_date;
    return round($datediff / (60 * 60 * 24));
}

function arrayToString($array)
{
    $wNin = "";
    foreach ($array as $k => $w) {
        if (count($array) - 1 == $k) {
            $wNin .= "'$w'";
        } else {
            $wNin .= "'$w', ";
        }
    }

    return $wNin;
}

function satuan($id)
{
    switch ($id) {
        case '1':
            return "Rupiah";
            break;
        case '2':
            return "Persen";
            break;

        default:
            return "";
            break;
    }
}

function get_between_dates($startDate, $endDate)
{

    $rangArray = [];
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateUUID()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

function kp()
{
    return auth()->user()->kode_perusahaan;
}

function getPerusahaan()
{
    return auth()->user() ? Perusahaan::where('kode_perusahaan', kp())->first() : new Perusahaan();
}

function get_logo()
{
    return auth()->user() ? Perusahaan::where('kode_perusahaan', kp())->value('logo') : "";
}

// DepthHelpoer
function DepthHelper($idToFind)
{
    return GetParentHelper($idToFind);
}

// Recursive Helper function
function GetParentHelper($id, $depth = 0)
{
    $model = Tingkat::where('kode_tingkat', $id)->first();

    if ($model->parent_id != null) {
        return $depth;
    } else {
        $depth++;
        return GetParentHelper($model->parent_id, $depth);
    }
}

function uploadImage($imageString, $path)
{
    if ($imageString) {
        $extension = explode('/', explode(':', substr($imageString, 0, strpos($imageString, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($imageString, 0, strpos($imageString, ',') + 1);
        $image = str_replace($replace, '', $imageString);
        $image = str_replace(' ', '+', $image);
        $imageName = date("YmdHis") . Str::random(10) . '.' . $extension;

        $foto = "$path/$imageName";
        Storage::disk('public')->put("/$foto", base64_decode($image));
    } else {
        $foto = "";
    }

    return $foto;
}


function getGenUsia()
{
    $data = [
        [
            "usia_terendah" => 17,
            "usia_tertinggi" => 24,
            "nama" => "17-24 tahun"
        ],
        [
            "usia_terendah" => 25,
            "usia_tertinggi" => 40,
            "nama" => "25-40 tahun"
        ],
        [
            "usia_terendah" => 41,
            "usia_tertinggi" => 56,
            "nama" => "41-56 tahun"
        ],
        [
            "usia_terendah" => 57,
            "usia_tertinggi" => 75,
            "nama" => "57-75 tahun"
        ],
    ];
    return $data;
}

function validasi_master($array, $exp = 3)
{
    $namaModel = ex_model($array[$exp-2]);
    $id = $array[$exp];
   

    if ($exp == 3) {
        $model = 'App\Models\Master\\' . ucfirst($namaModel);
    } elseif ($exp == 4) {
        $model = 'App\Models\Master\\' . ucfirst($array[1]) . "\\" . ucfirst($namaModel);
    }

    if (strlen($id) >= 36) {
        $field = ex_field($namaModel);
        $kode_perusahaan = $model::where($field, $id)->value('kode_perusahaan');
    } else {
        $kode_perusahaan = $model::where('id', $id)->value('kode_perusahaan');
    }

    if ($kode_perusahaan != auth()->user()->kode_perusahaan) {
        return true;
    } else {
        return false;
    }
}

function validasi_data_pegawai($array)
{
    $namaModel = $array[1];
    $nip = $array[2];
    if (count($array) == 6) {
        $id = is_integer($array[4]) ? $array[4] : $array[5];
    } else {
        $id = $array[4];
    }
    if ($namaModel == 'level') {
        $namaModel = 'eselon';
    }

    // array model tanpa kata riwayat
    $modelNotRiwayat = ['keluarga'];

    if (in_array($namaModel, $modelNotRiwayat)) {
        $model = 'App\Models\Pegawai\\' . ucfirst($namaModel);
    } else {
        // saat ini hanya model yang didahului riwayat
        $model = 'App\Models\Pegawai\Riwayat' . ucfirst($namaModel);
    }

    $kode_perusahaan = $model::where('nip', $nip)->where('id', $id)->value('kode_perusahaan');

    if ($kode_perusahaan != auth()->user()->kode_perusahaan) {
        return true;
    } else {
        return false;
    }
}

function ex_model($namaModel)
{
    if ($namaModel == 'level') {
        $namaModel = 'eselon';
    }elseif($namaModel == 'penambahan'){
        $namaModel = 'tambahan';
    }elseif($namaModel == 'jam-kerja-pegawai'){
        $namaModel = 'jksPegawai';
    }

    return $namaModel;
}

function ex_field($namaModel)
{
    if ($namaModel == 'tingkat') {
        $field = 'kode_skpd';
    } else if($namaModel == 'pengurangan') {
        $field = 'kode_kurang';
    } else if($namaModel == 'tambahan') {
        $field = 'kode_tambah';
    } else if($namaModel == 'jksPegawai') {
        $field = 'kode_jam_kerja';
    } else {
        $field = 'kode_' . strtolower($namaModel);
    }

    return $field;
}

function get_kode_perusahaan_pengumuman($id)
{
    return Pengumuman::where('id', $id)->value('kode_perusahaan');
}