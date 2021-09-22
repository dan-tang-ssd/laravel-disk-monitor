<?php

namespace Spatie\LaravelDiskMonitor\Tests\Http\Controllers;

use Spatie\LaravelDiskMonitor\Tests\TestCase;

class DiskMetricksControllerTest extends TestCase
{

    /** @test */
    public function it_can_display_the_list_of_entries()
    {
        $this
            ->get('disk-monitor')
            ->assertOk();
    }
}
