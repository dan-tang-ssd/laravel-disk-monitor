<?php

namespace Spatie\LaravelDiskMonitor\Tests\Feature\Commands;

use Illuminate\Support\Facades\Storage;
use Spatie\LaravelDiskMonitor\Commands\RecordDiskMetricsCommand;
use Spatie\LaravelDiskMonitor\Models\DiskMonitorEntry;
use Spatie\LaravelDiskMonitor\Tests\TestCase;

class RecordDiskMetricsCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // use a fake local disk
        Storage::fake('local');

        // create another fake disk
        Storage::fake('anotherDisk');
    }

    /** @test */
    public function it_will_record_the_file_count_for_a_single_disk()
    {
        //Storage::disk('local')->put('test.txt', 'test');

        $this->artisan(RecordDiskMetricsCommand::class)->assertExitCode(0);

        // check number of records in table for model DiskMonitorEntry,
        // it should be always 1 because it is a memory database
        //$this->assertCount(1, DiskMonitorEntry::get());

        // check number of files, it should be 1
        $entry = DiskMonitorEntry::last();
        $this->assertEquals(0, $entry->file_count);

        // to check whether file_count is a string or an integer
        // before adding casts in DiskMonitorEntry.php, it is a string
        // after adding casts in DiskMonitorEntry.php, it is an integer
        //dd($entry->file_count);

        Storage::disk('local')->put('test.txt', 'text');
        $this->artisan(RecordDiskMetricsCommand::class)->assertExitCode(0);
        $entry = DiskMonitorEntry::last();
        $this->assertEquals(1, $entry->file_count);
    }

    /** @test */
    public function it_will_record_the_file_count_for_multiple_disks()
    {
        config()->set('disk-monitor.disk_names', ['local', 'anotherDisk']);
        Storage::disk('anotherDisk')->put('test.txt', 'text');

        $this->artisan(RecordDiskMetricsCommand::class)->assertExitCode(0);

        // check number of records in table for model DiskMonitorEntry,
        // it should be always 2 because it is a memory database

        $entries = DiskMonitorEntry::get();
        $this->assertCount(2, $entries);

        $this->assertEquals('local', $entries[0]->disk_name);
        $this->assertEquals(0, $entries[0]->file_count);

        $this->assertEquals('anotherDisk', $entries[1]->disk_name);
        $this->assertEquals(1, $entries[1]->file_count);
    }

}
