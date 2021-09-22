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
        /*
        // it is good to use "..." so people know it is an on-going process
        $this->comment('Recoding metrics...');

        $diskNames = config('disk-monitor.disk_names');

        // not sure why config file cannot be read, hardcode it to continue testing
        if ($diskNames == []) {
            $diskNames = ['local'];
        }        

        $fileCount = count(Storage::disk($diskName)->allFiles());

        // we need o have a Model
        DiskMonitorEntry::create([
            'disk_names' => $diskNames,
            'file_count' => $fileCount,
        ]);
        */

        collect(config('disk-monitor.disk_names'))
            ->each(fn(string $diskName) => $this->recordMetrics($diskName));

        // it is good to have "All done" at the end of command, so I know it reached the end
        // use exclaimation mark ! to indicate it is now done
        $this->comment('All done!');
    }


    protected function recordMetrics(string $diskName): void
    {
        $this->info("Recording metrics for disk `{$diskName}`...");

        $disk = Storage::disk($diskName);

        $fileCount = count($disk->allFiles());

        DiskMonitorEntry::create([
            'disk_name' => $diskName,
            'file_count' => $fileCount,
        ]);

    }

}
