<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Master\Device;
use App\Models\Presensi\PresensiFree;
use Illuminate\Http\Request;

class CronJobController extends Controller
{

    public function istirahat()
    {
        $hariIni = PresensiFree::where("jam_istirahat_mulai", "!=", null)->whereNull("jam_istirahat_selesai")->where("tanggal", date("Y-m-d"))->get();
        
        if(count($hariIni) > 0){
            $arr = [];
            foreach ($hariIni as $val) {
                $menit = menit_dari_2jam($val->jam_istirahat_mulai, date("H:i:s"));
                if($val->rule_istirahat - $menit == 10){
                    array_push($arr, $val->nip);
                }
            }
            
            $devices = Device::whereIn('nip', $arr)->get()->pluck('player_id')->toArray();
    
            if(count($devices) > 0){
                send_onesignal($devices, [], "Pemberitahuan Istirahat", "Waktu istirahat anda tinggal 10 menit");
                return "success";
            }
            return "tidak ada device";
        }
        return "tidak ada presensi";
    }

}
