<?php
namespace App\Libs;

class Watchdog {
    use WatchdogTrait;

    public function getInstance()
    {
        return auth()->user();
    }

}
