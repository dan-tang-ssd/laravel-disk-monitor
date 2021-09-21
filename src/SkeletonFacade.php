<?php

namespace Spatie\LaravelDiskMonitor;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\LaravelDiskMonitor\LaravelDiskMonitor
 */
class LaravelDiskMonitorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-disk-monitor';
    }
}
