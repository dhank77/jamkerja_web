<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PresensiLaporanApiResource;
use App\Http\Resources\Api\ShiftApiResource;
use App\Http\Resources\Api\ApiJamKerjaStatisResource;
use App\Http\Resources\Master\JkdMasterResource;
use App\Http\Resources\Presensi\PresensiLaporanFreeResource;
use App\Jobs\ProcessOneSignal;
use Illuminate\Support\Str;
use App\Jobs\ProcessWaNotif;
use App\Models\Master\JamKerjaStatis;
use App\Models\Master\JkdJadwal;
use App\Models\Master\JkdMaster;
use App\Models\Master\JksPegawai;
use App\Models\Master\Lokasi;
use App\Models\Master\Shift;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\RiwayatShift;
use App\Models\Pegawai\Wajah;
use App\Models\Presensi\PresensiFree;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PresensiApiController extends Controller
{
    public function lokasi()
    {
        $nip = request('nip');

        $user = User::where('nip', $nip)->first();

        if ($user && $user->kordinat != "" && $user->longitude != "" && $user->latitude != "" && $user->jarak > 0) {
            return response()->json([
                'kordinat' => $user->kordinat,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'jarak' => $user->jarak,
                'keterangan' => 'Pegawai'
            ]);
        }

        $rwJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
        $tingkat = $rwJabatan?->tingkat;
        $kode_tingkat = $tingkat?->kode_tingkat ?? 0;
        $level = $tingkat?->eselon;
        $divisi = $rwJabatan?->skpd;
        $kode_skpd = $divisi?->kode_skpd;

        if ($rwJabatan) {
            // Jabatan
            if ($tingkat && $tingkat->kordinat != "" && $tingkat->longitude != "" && $tingkat->latitude != "" && $tingkat->jarak > 0) {
                return response()->json([
                    'kordinat' => $tingkat->kordinat,
                    'latitude' => $tingkat->latitude,
                    'longitude' => $tingkat->longitude,
                    'jarak' => $tingkat->jarak,
                    'keterangan' => 'Jabatan'
                ]);
            }

            // Level
            if ($level && $level->kordinat != "" && $level->longitude != "" && $level->latitude != "" && $level->jarak > 0) {
                return response()->json([
                    'kordinat' => $level->kordinat,
                    'latitude' => $level->latitude,
                    'longitude' => $level->longitude,
                    'jarak' => $level->jarak,
                    'keterangan' => 'Level'
                ]);
            }

            // Divisi
            if ($divisi && $divisi->kordinat != "" && $divisi->longitude != "" && $divisi->latitude != "" && $divisi->jarak > 0) {
                return response()->json([
                    'kordinat' => $divisi->kordinat,
                    'latitude' => $divisi->latitude,
                    'longitude' => $divisi->longitude,
                    'jarak' => $divisi->jarak,
                    'keterangan' => 'Divisi'
                ]);
            }
        }

        // Lokasi Pegawai
        $lokasiPegawai = Lokasi::select('*')
            ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
            ->whereRaw("(lokasi.keterangan = 1 AND lokasi_detail.keterangan_id = '$nip')")
            ->whereNull('lokasi_detail.deleted_at')
            ->first();
        if ($lokasiPegawai && $lokasiPegawai->kordinat != "" && $lokasiPegawai->longitude != "" && $lokasiPegawai->latitude != "" && $lokasiPegawai->jarak > 0) {
            return response()->json([
                'kordinat' => $lokasiPegawai->kordinat,
                'latitude' => $lokasiPegawai->latitude,
                'longitude' => $lokasiPegawai->longitude,
                'jarak' => $lokasiPegawai->jarak,
                'keterangan' => 'Lokasi Pegawai'
            ]);
        }

        // Lokasi Tingkat
        $lokasiTingkat = Lokasi::select('*')
            ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
            ->whereRaw("(lokasi.keterangan = 2 AND lokasi_detail.keterangan_id = '$kode_tingkat')")
            ->whereNull('lokasi_detail.deleted_at')
            ->first();
        if ($lokasiTingkat && $lokasiTingkat->kordinat != "" && $lokasiTingkat->longitude != "" && $lokasiTingkat->latitude != "" && $lokasiTingkat->jarak > 0) {
            return response()->json([
                'kordinat' => $lokasiTingkat->kordinat,
                'latitude' => $lokasiTingkat->latitude,
                'longitude' => $lokasiTingkat->longitude,
                'jarak' => $lokasiTingkat->jarak,
                'keterangan' => 'Lokasi Tingkat'
            ]);
        }

        // Lokasi Divisi
        $lokasiDivisi = Lokasi::select('*')
            ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
            ->whereRaw("(lokasi.keterangan = 3 AND lokasi_detail.keterangan_id = '$kode_skpd')")
            ->whereNull('lokasi_detail.deleted_at')
            ->first();
        if ($lokasiDivisi && $lokasiDivisi->kordinat != "" && $lokasiDivisi->longitude != "" && $lokasiDivisi->latitude != "" && $lokasiDivisi->jarak > 0) {
            return response()->json([
                'kordinat' => $lokasiDivisi->kordinat,
                'latitude' => $lokasiDivisi->latitude,
                'longitude' => $lokasiDivisi->longitude,
                'jarak' => $lokasiDivisi->jarak,
                'keterangan' => 'Lokasi Divisi'
            ]);
        }

        return response()->json([
            'kordinat' => 0,
            'latitude' => 0,
            'longitude' => 0,
            'jarak' => 0,
            'keterangan' => 'Error'
        ]);
    }

    public function shift()
    {
        $nip = request('nip');

        $user = User::where('nip', $nip)->first();

        $rwJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
        $tingkat = $rwJabatan?->tingkat;
        $kode_tingkat = $tingkat?->kode_tingkat ?? 0;
        $divisi = $rwJabatan?->skpd;
        $kode_skpd = $divisi?->kode_skpd;

        $shift_pegawai = RiwayatShift::where('is_akhir', 1)->where('nip', $nip)->first();
        if ($shift_pegawai) {
            $lokasi = $shift_pegawai->kode_shift;
        } else {
            $lokasi = Lokasi::select('*')
                ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
                ->whereRaw("(lokasi.keterangan = 1 AND lokasi_detail.keterangan_id = '$nip')")
                ->orWhereRaw("(lokasi.keterangan = 2 AND lokasi_detail.keterangan_id = '$kode_tingkat')")
                ->orWhereRaw("(lokasi.keterangan = 3 AND lokasi_detail.keterangan_id = '$kode_skpd')")
                ->whereNull('lokasi_detail.deleted_at')
                ->value('kode_shift');
        }


        $shift = Shift::where('kode_shift', $lokasi)->first();
        $shift->kode_tingkat = $kode_tingkat;
        $shift = ShiftApiResource::make($shift);

        return response()->json($shift);
    }

    public function master_jam_kerja()
    {
        $data = JkdMaster::latest()->get();
        JkdMasterResource::withoutWrapping();
        $data = JkdMasterResource::collection($data);

        return response()->json($data);
    }

    public function jam_kerja()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();

        if (!$user) {
            return response()->json(['status' => false]);
        }

        $jkd = JkdJadwal::where("nip", $nip)->where("tanggal", date("Y-m-d"))->first();
        if ($jkd) {
            $data = JkdMaster::where('kode_jkd', $jkd->kode_jkd)->first();
            $data->keterangan = "dinamis";
            return response()->json($data);
        }

        $jam = JksPegawai::where('nip', $nip)->first();
        if ($jam) {
            $day =  date("w");
            $data = JamKerjaStatis::where('kode_jam_kerja', $jam->kode_jam_kerja)->where('hari', $day)->first();
            $data->keterangan = "statis";
            return response()->json($data);
        }
    }

    public function jam_kerja_statis()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();

        if (!$user) {
            return response()->json(['status' => false]);
        }

        $jam = JksPegawai::where('nip', $nip)->first();
        if ($jam) {
            $data = JamKerjaStatis::where('kode_jam_kerja', $jam->kode_jam_kerja)->orderBy('hari')->get();
            ApiJamKerjaStatisResource::withoutWrapping();
            $data = ApiJamKerjaStatisResource::collection($data);
            return response()->json($data);
        }

        return [];
    }

    public function jam_kerja_calender()
    {
        $nip = request('nip');
        $bulan = request('bulan') ?? date("m");
        $tahun = request('tahun') ?? date("Y");

        $hari_awal = date("w", strtotime("$tahun-$bulan-1"));
        $tanggal_awal = date("Y-m-d", strtotime("$tahun-$bulan-1 -$hari_awal days"));


        $total_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $hari_akhir = date("w", strtotime("$tahun-$bulan-$total_akhir"));
        $plus_hari = 6 - $hari_akhir;
        $tanggal_akhir = date("Y-m-d", strtotime("$tahun-$bulan-$total_akhir +$plus_hari days"));
        $dates = getBetweenDates($tanggal_awal, $tanggal_akhir);


        $arr = [];
        $arrPekan = [];
        foreach ($dates as $k => $val) {
            $data = JkdJadwal::with('jkd_master')->where('nip', $nip)->where("tanggal", $val)->first();
            $send = [
                'tanggal' => $val,
                'hari' => hari_kecil(date("w", strtotime($val))),
                'tanggal_saja' => date("d", strtotime($val)),
                'kode_jkd' => $data ? $data->kode_jkd : "",
                'color' => date("m", strtotime($val)) != $bulan ? "0xFFC0C0C0" : "0xFF000000",
                'color_kode' => $data ? (date("m", strtotime($val)) == $bulan ? str_replace("#", "0xFF", strtoupper(optional($data->jkd_master)->color)) : "0xFFFFFFFF") : "0xFFFFFFFF",
            ];
            if (($k + 1) % 7 == 0) {
                array_push($arrPekan, $send);
                array_push($arr, $arrPekan);
                $arrPekan = [];
            } else {
                array_push($arrPekan, $send);
            }
        }

        return response()->json($arr);
    }

    public function store_free()
    {
        $nip = request('nip');
        $kordinat = request('kordinat');
        $field = request('field');

        $date = request('date');
        $toler1Min = strtotime("-5 minutes");
        $dateSend = strtotime($date);

        $image_64 = request('image');
        if ($image_64) {
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = date("YmdHis") . Str::random(10) . '.' . $extension;

            $foto = "presensi/$nip/$imageName";
            Storage::disk('public')->put("/$foto", base64_decode($image));
        } else {
            $foto = "";
        }

        $timeZone = request('timezone') ?? 'WITA';
        if ($timeZone == 'WIB') {
            $tanggalIn = date('H:i:s', strtotime(date('Y-m-d H:i:s')) - (60 * 60));
            $dateSend = strtotime($date) + (60 * 60);
        } elseif ($timeZone == 'WIT') {
            $tanggalIn = date('H:i:s', strtotime(date('Y-m-d H:i:s')) + (60 * 60));
            $dateSend = strtotime($date) - (60 * 60);
        } else {
            $tanggalIn = date('H:i:s');
        }

        // comment if dev
        if ($dateSend < $toler1Min) {
            return response()->json(['status' => 'Error', 'messages' => 'Harap memperbaiki jam Handphone Anda!']);
        }

        $user = User::where('nip', $nip)->first();
        if (!$user) {
            return response()->json(['status' => 'Error', 'messages' => 'User tidak ditemukan!']);
        }

        $cek = PresensiFree::whereDate("tanggal", date("Y-m-d"))->where("jam_$field", "!=", null)->where('nip', $nip)->first();
        if ($cek) {
            return response()->json(['status' => 'Error', 'messages' => 'Anda telah melakukan presensi atau istirahat hari ini!']);
        }

        $jam_kerja = jam_kerja_nip($nip);
        if (!$jam_kerja) {
            return response()->json(['status' => 'Error', 'messages' => 'Jam kerja anda belum ditetapkan!']);
        }

        $rwJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
        $kode_skpd = $rwJabatan?->kode_skpd;

        $telat = 0;
        if ($field == "datang" || $field == "pulang") {
            $nameField = "jam_$field";
            $nameToleransi = "toleransi_$field";
            if ($field == "pulang") {
                if (strtotime($jam_kerja->jam_datang) > strtotime($jam_kerja->jam_pulang)) {
                    $cekDatang = PresensiFree::whereDate('tanggal', date("Y-m-d", strtotime('-1 days')))->where("jam_datang", '!=', null)->whereNull('jam_pulang')->where('nip', $nip)->value('id');
                } else {
                    $cekDatang = PresensiFree::whereDate('tanggal', date("Y-m-d"))->where("jam_datang", '!=', null)->where('nip', $nip)->value('id');
                }
                if (!$cekDatang) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda belum melakukan check in!']);
                }
            }

            if ($jam_kerja->$nameToleransi > 0) {
                $rule_jam = date("H:i", strtotime(date("Y-m-d") . " " . $jam_kerja->$nameField  . " +" . $jam_kerja->$nameToleransi . "minutes"));
            } else {
                $rule_jam = $jam_kerja->$nameField;
            }

            if($field == 'datang'){
                $menit_telat = menit_dari_2jam($rule_jam, $tanggalIn);
                if ($menit_telat > 0) {
                    $telat = $menit_telat;
                }
            }else{
                $menit_telat = menit_dari_2jam($tanggalIn, $rule_jam);
                if ($menit_telat > 0) {
                    $telat = $menit_telat;
                }
            }
            $data = [
                "kode_skpd" => $kode_skpd,
                "jam_$field" => $tanggalIn,
                "rule_$field" => $rule_jam,
                "image_$field" => $foto,
                "status" => $jam_kerja->status,
                "kordinat_$field" => $kordinat,
                "rule_istirahat" => $jam_kerja->istirahat,
            ];

            if($field == 'pulang'){
                // check jam pulang dibawah jam 9 pagi
                if (strtotime($jam_kerja->jam_datang) > strtotime($jam_kerja->jam_pulang)) {
                    $cekMasuk = PresensiFree::whereDate('tanggal', date("Y-m-d", strtotime('-1 days')))->where('nip', $nip)->first();
                    $cr = $cekMasuk->update($data);
                } else {
                    $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
                }

            }else{
                $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
            }
        } else {
            if ($field == "istirahat_selesai") {
                // if ($dateSend < strtotime(date("Y-m-d") . " 08:59:59")) {
                //     $cekBreak = PresensiFree::whereDate("tanggal", date("Y-m-d", strtotime('-1 days')))->where("jam_istirahat_mulai", '!=', null)->where('nip', $nip)->value('id');
                // }else{
                    $cekBreak = PresensiFree::whereDate("tanggal", date("Y-m-d"))->where("jam_istirahat_mulai", '!=', null)->where('nip', $nip)->value('id');
                // }
                if (!$cekBreak) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda belum melakukan presensi break!']);
                }
                $istirahat_mulai = PresensiFree::whereDate("tanggal", date("Y-m-d"))->where("jam_istirahat_mulai", "!=", null)->where('nip', $nip)->value("jam_istirahat_mulai") ?? 0;
                $menit_istirahat = menit_dari_2jam($istirahat_mulai, $tanggalIn);
                if ($menit_istirahat > $jam_kerja->istirahat) {
                    $telat = ($menit_istirahat - $jam_kerja->istirahat);
                }
            }
            $data = [
                "kode_skpd" => $kode_skpd,
                "jam_$field" => $tanggalIn,
                "status" => $jam_kerja->status,
                "rule_istirahat" => $jam_kerja->istirahat,
            ];

            // if ($dateSend < strtotime(date("Y-m-d") . " 08:59:59")) {
            //     $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
            // }else{
                $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
            // }
        }
        if ($cr) {
            if ($telat > 0) {
                if($field == 'pulang'){
                    $text = "Berhasil melakukan absensi, Akan tetapi anda pulang cepat $telat menit!";
                }else{
                    $text = "Berhasil melakukan absensi, Akan tetapi anda telat $telat menit!";
                }
            } else {
                $text = "Berhasil melakukan absensi!";
            }
            dispatch(new ProcessOneSignal($nip, "SBC Absensi!", $text));
            return response()->json(['status' => 'Success', 'messages' =>  $text]);
        } else {
            return response()->json(['status' => 'Error', 'messages' => 'Jam kerja anda belum ditetapkan!']);
        }
    }

    public function store_free_face()
    {
        $nip = request('nip');
        $kordinat = request('kordinat');
        $field = request('field');

        $date = request('date');
        $toler1Min = strtotime("-5 minutes");
        $dateSend = strtotime($date);

        $image_64 = request('image');
        if ($image_64) {
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = date("YmdHis") . Str::random(10) . '.' . $extension;

            $foto = "presensi/$nip/$imageName";
            Storage::disk('public')->put("/$foto", base64_decode($image));
        } else {
            $foto = "";
            return response()->json(['status' => 'Error', 'messages' => 'Anda harus melakukan foto terlebih dahulu!']);
        }

        $timeZone = request('timezone') ?? 'WITA';
        if ($timeZone == 'WIB') {
            $tanggalIn = date('H:i:s', strtotime(date('Y-m-d H:i:s')) - (60 * 60));
            $dateSend = strtotime($date) + (60 * 60);
        } elseif ($timeZone == 'WIT') {
            $tanggalIn = date('H:i:s', strtotime(date('Y-m-d H:i:s')) + (60 * 60));
            $dateSend = strtotime($date) - (60 * 60);
        } else {
            $tanggalIn = date('H:i:s');
        }

        $confidance = 0;

        $data = recog_image($nip, $foto);
        // var_dump($data); die;
        // $wajah = Wajah::where('nip', $nip)->value('file');
        // if($wajah == ""){
        //     return response()->json(['status' => 'Error', 'messages' => "Wajah acuan belum ada!"]);
        // }
        // $data = compare_images('faces/006/006-face-20230131083935.jpg', $foto);
        // return $data;
        if($data['status'] != 'success'){
            Storage::delete($foto);
            $status = $data['status'];
            return response()->json(['status' => 'Error', 'messages' => "Wajah tidak dikenali, status : $status, silahkan coba lagi!"]);
        }
        if($data['confidence'] < 50){
            Storage::delete($foto);
            $persen = round($data['confidence'], 2);
            return response()->json(['status' => 'Error', 'messages' => "Tingkat kemiripan hanya $persen%, silahkan coba lagi!"]);
        }

        $confidance = $data['confidence'];

        // comment if dev
        if ($dateSend < $toler1Min) {
            return response()->json(['status' => 'Error', 'messages' => 'Harap memperbaiki jam Handphone Anda!']);
        }

        $user = User::where('nip', $nip)->first();
        if (!$user) {
            return response()->json(['status' => 'Error', 'messages' => 'User tidak ditemukan!']);
        }

        $cek = PresensiFree::whereDate("tanggal", date("Y-m-d"))->where("jam_$field", "!=", null)->where('nip', $nip)->first();
        if ($cek) {
            return response()->json(['status' => 'Error', 'messages' => 'Anda telah melakukan presensi atau istirahat hari ini!']);
        }

        $jam_kerja = jam_kerja_nip($nip);
        if (!$jam_kerja) {
            return response()->json(['status' => 'Error', 'messages' => 'Jam kerja anda belum ditetapkan!']);
        }

        $rwJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
        $kode_skpd = $rwJabatan?->kode_skpd;

        $telat = 0;
        if ($field == "datang" || $field == "pulang") {
            $nameField = "jam_$field";
            $nameToleransi = "toleransi_$field";
            if ($field == "pulang") {
                if (strtotime($jam_kerja->jam_datang) > strtotime($jam_kerja->jam_pulang)) {
                    $cekDatang = PresensiFree::whereDate('tanggal', date("Y-m-d", strtotime('-1 days')))->where("jam_datang", '!=', null)->whereNull('jam_pulang')->where('nip', $nip)->value('id');
                } else {
                    $cekDatang = PresensiFree::whereDate('tanggal', date("Y-m-d"))->where("jam_datang", '!=', null)->where('nip', $nip)->value('id');
                }
                if (!$cekDatang) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda belum melakukan check in!']);
                }
            }

            if ($jam_kerja->$nameToleransi > 0) {
                $rule_jam = date("H:i", strtotime(date("Y-m-d") . " " . $jam_kerja->$nameField  . " +" . $jam_kerja->$nameToleransi . "minutes"));
            } else {
                $rule_jam = $jam_kerja->$nameField;
            }

            if($field == 'datang'){
                $menit_telat = menit_dari_2jam($rule_jam, $tanggalIn);
                if ($menit_telat > 0) {
                    $telat = $menit_telat;
                }
            }else{
                $menit_telat = menit_dari_2jam($tanggalIn, $rule_jam);
                if ($menit_telat > 0) {
                    $telat = $menit_telat;
                }
            }
            $data = [
                "kode_skpd" => $kode_skpd,
                "jam_$field" => $tanggalIn,
                "rule_$field" => $rule_jam,
                "image_$field" => $foto,
                "status" => $jam_kerja->status,
                "kordinat_$field" => $kordinat,
                "rule_istirahat" => $jam_kerja->istirahat,
            ];

            if($field == 'pulang'){
                // check jam pulang dibawah jam 9 pagi
                if (strtotime($jam_kerja->jam_datang) > strtotime($jam_kerja->jam_pulang)) {
                    $cekMasuk = PresensiFree::whereDate('tanggal', date("Y-m-d", strtotime('-1 days')))->where('nip', $nip)->first();
                    $cr = $cekMasuk->update($data);
                } else {
                    $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
                }

            }else{
                $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
            }
        } else {
            if ($field == "istirahat_selesai") {
                // if ($dateSend < strtotime(date("Y-m-d") . " 08:59:59")) {
                //     $cekBreak = PresensiFree::whereDate("tanggal", date("Y-m-d", strtotime('-1 days')))->where("jam_istirahat_mulai", '!=', null)->where('nip', $nip)->value('id');
                // }else{
                    $cekBreak = PresensiFree::whereDate("tanggal", date("Y-m-d"))->where("jam_istirahat_mulai", '!=', null)->where('nip', $nip)->value('id');
                // }
                if (!$cekBreak) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda belum melakukan presensi break!']);
                }
                $istirahat_mulai = PresensiFree::whereDate("tanggal", date("Y-m-d"))->where("jam_istirahat_mulai", "!=", null)->where('nip', $nip)->value("jam_istirahat_mulai") ?? 0;
                $menit_istirahat = menit_dari_2jam($istirahat_mulai, $tanggalIn);
                if ($menit_istirahat > $jam_kerja->istirahat) {
                    $telat = ($menit_istirahat - $jam_kerja->istirahat);
                }
            }
            $data = [
                "kode_skpd" => $kode_skpd,
                "jam_$field" => $tanggalIn,
                "status" => $jam_kerja->status,
                "rule_istirahat" => $jam_kerja->istirahat,
            ];

            // if ($dateSend < strtotime(date("Y-m-d") . " 08:59:59")) {
            //     $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
            // }else{
                $cr = PresensiFree::updateOrCreate(['tanggal' => date("Y-m-d"), 'nip' => $nip], $data);
            // }
        }
        if ($cr) {
            if ($telat > 0) {
                if($field == 'pulang'){
                    $text = "Berhasil melakukan absensi, Akan tetapi anda pulang cepat $telat menit, tingkat kemiripan: $confidance!";
                }else{
                    $text = "Berhasil melakukan absensi, Akan tetapi anda telat $telat menit, tingkat kemiripan: $confidance!";
                }
            } else {
                $text = "Berhasil melakukan absensi, tingkat kemiripan: $confidance!";
            }
            dispatch(new ProcessOneSignal($nip, "SBC Absensi!", $text));
            return response()->json(['status' => 'Success', 'messages' =>  $text]);
        } else {
            return response()->json(['status' => 'Error', 'messages' => 'Jam kerja anda belum ditetapkan!']);
        }
    }

    public function store()
    {
        $nip = request('nip');
        $kordinat = request('kordinat');
        $kode_shift = request('kode_shift');
        $kode_tingkat = request('kode_tingkat');

        $image_64 = request('image');
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = date("YmdHis") . Str::random(10) . '.' . $extension;

        $date = request('date');
        $toler1Min = strtotime("-5 minutes");
        $dateSend = strtotime($date);

        if ($image_64) {
            $foto = "presensi/$nip/$imageName";
            Storage::disk('public')->put("/$foto", base64_decode($image));
        } else {
            $foto = "";
        }

        $timeZone = request('timezone') ?? 'WITA';

        if ($dateSend < $toler1Min) {
            return response()->json(['status' => 'Error', 'messages' => 'Harap memperbaiki jam Handphone Anda!']);
        }

        if ($timeZone == 'WIB') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - (60 * 60));
            $dateSend = strtotime($date) + (60 * 60);
        } elseif ($timeZone == 'WIT') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + (60 * 60));
            $dateSend = strtotime($date) - (60 * 60);
        } else {
            $tanggalIn = date('Y-m-d H:i:s');
        }

        $user = User::where('nip', $nip)->first();
        if (!$user) {
            return response()->json(['status' => 'Error', 'messages' => 'User tidak ditemukan!']);
        }

        // blok perizinan
        // $perizinan = perizinan_pegawai($nip, date('Y-m-d'));
        // if ($perizinan) {
        //     return response()->json(['status' => 'Error', 'messages' => 'Anda sedang dalam masa perizinan!']);
        // }

        $shift = Shift::where('kode_shift', $kode_shift)->first();


        $bukaPagiTime = strtotime(date('Y-m-d') . " " . $shift->jam_buka_datang);
        $tutupPagiTime = strtotime(date('Y-m-d') . " " . $shift->jam_tutup_datang);

        $bukaSiangTime = strtotime(date('Y-m-d') . " " . $shift->jam_buka_istirahat);
        $tutupSiangTime = strtotime(date('Y-m-d') . " " . $shift->jam_tutup_istirahat);

        $bukaSoreTime = strtotime(date('Y-m-d') . " " . $shift->jam_buka_pulang);
        $tutupSoreTime = strtotime(date('Y-m-d') . " " . $shift->jam_tutup_pulang);


        if ($dateSend >= $bukaPagiTime && $dateSend <= $tutupPagiTime) {
            $cek = DataPresensi::where('nip', $nip)->whereDate('tanggal_datang', date('Y-m-d'))->count();
            if ($cek > 0) {
                return response()->json(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi pagi ini!']);
            } else {
                $data = [
                    'nip' => $nip,
                    'kordinat_datang' => $kordinat,
                    'foto_datang' => $foto,
                    'kode_tingkat' => $kode_tingkat,
                    'kode_shift' => $kode_shift,
                    'tanggal_datang' => $tanggalIn
                ];
                $cr = DataPresensi::create($data);
                if ($cr) {
                    if ($user->no_hp != "") {
                        //Telat 
                        if (strtotime($tanggalIn) > strtotime(date("Y-m-d", strtotime($tanggalIn)) . $shift->jam_tepat_datang)) {
                            $dateTimeObject1 = date_create(date("Y-m-d", strtotime($tanggalIn)) . " " . $shift->jam_tepat_datang);
                            $dateTimeObject2 = date_create($tanggalIn);

                            $difference = date_diff($dateTimeObject1, $dateTimeObject2);

                            $telat_pagi = $difference->h * 60;
                            $telat_pagi += $difference->i;

                            if ($telat_pagi > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat $telat_pagi menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Pagi ini! :D'));
                            }
                        } else {
                            dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Pagi ini! :D'));
                        }
                    }
                    return response()->json(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'pagi']);
                } else {
                    return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
                }
            }
        } else if ($dateSend >= $bukaSiangTime && $dateSend <= $tutupSiangTime) {
            $cek = DataPresensi::where('nip', $nip)->whereDate('tanggal_datang', date('Y-m-d'))->first();
            if ($cek) {
                $cekSiang = DataPresensi::where('nip', $nip)->whereDate('tanggal_istirahat', date('Y-m-d'))->count();
                if ($cekSiang > 0) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi siang ini!']);
                } else {
                    $data = [
                        'kordinat_istirahat' => $kordinat,
                        'foto_istirahat' => $foto,
                        'tanggal_istirahat' => $tanggalIn
                    ];
                    $cr = $cek->update($data);
                    if ($cr) {
                        return response()->json(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'siang']);
                    } else {
                        return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
                    }
                }
            } else {
                $cekSiang2 = DataPresensi::where('nip', $nip)->whereDate('tanggal_istirahat', date('Y-m-d'))->count();
                if ($cekSiang2 > 0) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi siang ini!']);
                } else {
                    $data = [
                        'nip' => $nip,
                        'kordinat_istirahat' => $kordinat,
                        'foto_istirahat' => $foto,
                        'kode_tingkat' => $kode_tingkat,
                        'kode_shift' => $kode_shift,
                        'tanggal_istirahat' => $tanggalIn
                    ];
                    $cr = DataPresensi::create($data);
                    if ($cr) {
                        return response()->json([
                            'status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!',
                            'keterangan' => 'siang'
                        ]);
                    } else {
                        return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
                    }
                }
            }
        } else if ($dateSend >= $bukaSoreTime && $dateSend <= $tutupSoreTime) {
            $cek = DataPresensi::where('nip', $nip)->whereDate('tanggal_datang', date('Y-m-d'))->first();
            $cekSiang = DataPresensi::where('nip', $nip)->whereDate('tanggal_istirahat', date('Y-m-d'))->first();
            if ($cek) {
                $cekSore = DataPresensi::where('nip', $nip)->whereDate('tanggal_pulang', date('Y-m-d'))->count();
                if ($cekSore > 0) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi sore ini!']);
                } else {
                    $data = [
                        'kordinat_pulang' => $kordinat,
                        'foto_pulang' => $foto,
                        'tanggal_pulang' => $tanggalIn
                    ];
                    $cr = $cek->update($data);
                    if ($cr) {
                        if ($user->no_hp != "") {
                            $telatSore = telat_sore($tanggalIn, $shift->jam_tepat_pulang);
                            if ($telatSore > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda lebih cepat $telatSore menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D'));
                            }
                        }
                        return response()->json(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'sore']);
                    } else {
                        return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
                    }
                }
            } elseif ($cekSiang) {
                $cekSore3 = DataPresensi::where('nip', $nip)->whereDate('tanggal_pulang', date('Y-m-d'))->count();
                if ($cekSore3 > 0) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi sore ini!']);
                } else {
                    $data = [
                        'kordinat_pulang' => $kordinat,
                        'foto_pulang' => $foto,
                        'tanggal_pulang' => $tanggalIn
                    ];
                    $cr = $cekSiang->update($data);
                    if ($cr) {
                        if ($user->no_hp != "") {
                            $telatSore = telat_sore($tanggalIn, $shift->jam_tepat_pulang);
                            if ($telatSore > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda lebih cepat $telatSore menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D'));
                            }
                        }
                        return response()->json(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'sore']);
                    } else {
                        return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
                    }
                }
            } else {
                $cekSore2 = DataPresensi::where('nip', $nip)->whereDate('tanggal_pulang', date('Y-m-d'))->count();
                if ($cekSore2 > 0) {
                    return response()->json(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi sore ini!']);
                } else {
                    $data = [
                        'nip' => $nip,
                        'kordinat_pulang' => $kordinat,
                        'foto_pulang' => $foto,
                        'kode_tingkat' => $kode_tingkat,
                        'kode_shift' => $kode_shift,
                        'tanggal_pulang' => $tanggalIn
                    ];
                    $cr = DataPresensi::create($data);
                    if ($cr) {
                        if ($user->no_hp != "") {
                            $telatSore = telat_sore($tanggalIn, $shift->jam_tepat_pulang);
                            if ($telatSore > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda lebih cepat $telatSore menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D'));
                            }
                        }
                        return response()->json(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'sore']);
                    } else {
                        return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
                    }
                }
            }
        } else {
            return response()->json(['status' => 'Error', 'messages' => 'Anda tidak berada diwaktu presensi']);
        }
    }

    public function index()
    {
        $nip = request('nip');

        $data = DataPresensi::where('nip', $nip)->whereDate('created_at', date('Y-m-d'))->first();
        $datang = $data ? $data->tanggal_datang : false;
        $istirahat = $data ? $data->tanggal_istirahat : false;
        $pulang = $data ? $data->tanggal_pulang : false;

        $data = [
            'nip' => $nip,
            'datang' => $datang ? TRUE : FALSE,
            'waktu_datang' => $datang ? date('H:i:s', strtotime($datang)) : '-',
            'pulang' => $pulang ? TRUE : FALSE,
            'waktu_pulang' => $pulang ? date('H:i:s', strtotime($pulang)) : '-',
            'istirahat' => $istirahat ? TRUE : FALSE,
            'waktu_istirahat' => $istirahat ? date('H:i:s', strtotime($istirahat)) : '-',
        ];

        return response()->json($data);
    }

    public function laporan()
    {
        $nip = request('nip');
        $date = request('d') ? date('Y-m-d', strtotime(request('d'))) : date('Y-m-d', strtotime('-1 days'));
        $end =  request('e') ? date('Y-m-d', strtotime(request('e')) + (60 * 60 * 24)) : date('Y-m-d');

        $data = DataPresensi::select('data_presensi.id', 'data_presensi.nip', 'users.name', 'tanggal_datang', 'tanggal_istirahat', 'tanggal_pulang', 'data_presensi.created_at')
            ->leftJoin('users', 'users.nip', 'data_presensi.nip')
            ->where('data_presensi.nip', $nip)
            ->whereBetween('data_presensi.created_at', [$date, $end])
            ->whereNull('users.deleted_at')
            ->get();


        $data = PresensiLaporanApiResource::collection($data);

        return response()->json($data);
    }

    public function laporan_free()
    {
        $nip = request('nip');
        $date = request('d') ? date('Y-m-d', strtotime(request('d'))) : date('Y-m-d', strtotime('-1 days'));
        $end =  request('e') ? date('Y-m-d', strtotime(request('e')) + (60 * 60 * 24)) : date('Y-m-d');

        $data = PresensiFree::selectRaw("presensi_free.id, users.nip, users.name, presensi_free.tanggal, presensi_free.jam_datang, presensi_free.jam_pulang, presensi_free.jam_istirahat_mulai, presensi_free.jam_istirahat_selesai, presensi_free.image_datang, presensi_free.image_pulang, presensi_free.kordinat_datang, presensi_free.kordinat_pulang")
            ->leftJoin('users', 'users.nip', 'presensi_free.nip')
            ->where('presensi_free.nip', $nip)
            ->whereBetween('presensi_free.tanggal', [$date, $end])
            ->whereNull('users.deleted_at')
            ->get();


        $data = PresensiLaporanFreeResource::collection($data);

        return response()->json($data);
    }

    public function rekap_bulan()
    {
        $nip = request('nip');

        // set cut off
        $bulan = date('m');
        $tahun = date('Y');
        $bulanR = $bulan;
        $tahunR = $tahun;
        if ($bulan == 1) {
            $bulaniM = 12;
            $tahunIm = $tahun - 1;
        } else {
            $bulaniM = $bulan - 1;
            $tahunIm = $tahun;
        }

        $total_telat = 0;
        $pulang_cepat = 0;
        $tcm = 0;
        $tcp = 0;
        $tcb = 0;
        $tcab = 0;

        $kehadiran = PresensiFree::where('nip', $nip)->whereBetween('tanggal', ["$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25"])->get();

        foreach ($kehadiran as $data) {
            $telat = hitung_jam_menit_detik_dari_2_jam($data->rule_datang, $data->jam_datang);
            if ($telat != '-') {
                $total_telat += 1;
            }
            $pulang_awal = hitung_jam_menit_detik_dari_2_jam($data->jam_pulang, $data->rule_pulang);
            if ($pulang_awal != '-') {
                $pulang_cepat += 1;
            }

            if ($data->jam_datang == '') {
                $tcm += 1;
            }
            if ($data->jam_pulang == '') {
                $tcp += 1;
            }
            if ($data->jam_istirahat_mulai == '') {
                $tcb += 1;
            }
            if ($data->jam_istirahat_selesai == '') {
                $tcab += 1;
            }
        }
        $cuti = total_pengajuan_cutoff('App\Models\Pegawai\DataPengajuanCuti', "$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25", $nip);
        $ijin = total_pengajuan_cutoff('App\Models\Pengajuan\PengajuanIjin', "$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25", $nip);
        $izin = total_pengajuan_cutoff('App\Models\Pengajuan\PengajuanIzin', "$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25", $nip);
        $sakit = total_pengajuan_cutoff('App\Models\Pengajuan\PengajuanSakit', "$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25", $nip);

        $send = [
            'periode' => bulan(date('m')) . " " . date('Y'),
            'kehadiran' => count($kehadiran),
            'total_telat' => $total_telat,
            'pulang_cepat' => $pulang_cepat,

            'tcm' => $tcm,
            'tcp' => $tcp,
            'tcb' => $tcb,
            'tcab' => $tcab,

            'cuti' => $cuti,
            'ijin' => $ijin,
            'izin' => $izin,
            'sakit' => $sakit,
        ];

        return response()->json($send);
    }
}
