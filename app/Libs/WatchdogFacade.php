<?php
namespace App\Libs;
use Illuminate\Support\Facades\Facade;

class WatchdogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Watchdog::class;
    }
}