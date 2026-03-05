<?php

if (! function_exists('watchdog')) {
    function watchdog()
    {
        return new \App\Libs\Watchdog;
    }
}

if (! function_exists('sniff')) {
    function sniff($permission, $guardName = 'web')
    {
        return watchdog()->sniff($permission, $guardName);
    }
}