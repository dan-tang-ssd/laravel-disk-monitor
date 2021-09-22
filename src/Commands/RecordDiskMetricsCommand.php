<?php

namespace Spatie\LaravelDiskMonitor\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelDiskMonitor\Models\DiskMonitorEntry;

class RecordDiskMetricsCommand extends Command
{
    public $signature = 'disk-monitor:record-metrics';

    public $description = 'Record the metrics of a disk';

    public function handle()
    {
        // it is good to use "..." so people know it is an on-going process
        $this->comment('Recoding metrics...');

        $diskName = config('disk-monitor.disk-name');

        // not sure why config file cannot be read, hardcode it to continue testing
        if ($diskName == null) {
            $diskName = 'local';
        }        

        $fileCount = count(Storage::disk($diskName)->allFiles());

        // we need o have a Model
        DiskMonitorEntry::create([
            'disk_name' => $diskName,
            'file_count' => $fileCount,
        ]);

        // it is good to have "All done" at the end of command, so I know it reached the end
        // use exclaimation mark ! to indicate it is now done
        $this->comment('All done!');
    }
}
