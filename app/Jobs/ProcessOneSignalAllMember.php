<?php

namespace App\Jobs;

use App\Models\Master\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOneSignalAllMember implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pesan;
    public $title;

    public function __construct($title, $pesan)
    {
        $this->title = $title;
        $this->pesan = $pesan;
    }

    public function handle()
    {
        $device = Device::where('kode_perusahaan', kp())->get()->pluck("player_id")->toArray();
        send_onesignal($device, [], $this->title, $this->pesan);
    }
}
