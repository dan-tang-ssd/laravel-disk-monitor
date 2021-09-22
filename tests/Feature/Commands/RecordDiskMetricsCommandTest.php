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
    }

    /** @test */
    public function it_will_record_the_file_count_for_a_disk()
    {
        //Storage::disk('local')->put('test.txt', 'test');

        $this->artisan(RecordDiskMetricsCommand::class)->assertExitCode(0);

        // check number of records in table for model DiskMonitorEntry,
        // it should be always 1 because it is a memory database
        //$this->assertCount(1, DiskMonitorEntry::get());

        // check number of files, it should be 1
        $entry = DiskMonitorEntry::last();
        $this->assertEquals(0, $entry->file_count);

        Storage::put('test.txt', 'text');
        $this->artisan(RecordDiskMetricsCommand::class)->assertExitCode(0);
        $entry = DiskMonitorEntry::last();
        $this->assertEquals(1, $entry->file_count);
    }
}
