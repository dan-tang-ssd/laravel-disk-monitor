<?php

namespace Spatie\LaravelDiskMonitor\Http\Controllers;

use Spatie\LaravelDiskMonitor\Models\DiskMonitorEntry;

class DiskMetricsController
{
    public function __invoke()
    {
        // TODO: implement __invoke() method.

        // to make it short, just dump every metrics in a HTML table

        $entries = DiskMonitorEntry::latest()->get();

        return view('disk-monitor::entries');
    }
}