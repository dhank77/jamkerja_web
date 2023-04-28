<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWaNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $nohp;
    public $pesan;

    public function __construct($nohp, $pesan)
    {
        $this->nohp = $nohp;
        $this->pesan = $pesan;
    }

    public function handle()
    {
        send_wa($this->nohp, $this->pesan);
    }
}
