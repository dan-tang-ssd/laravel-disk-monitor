<?php

namespace Spatie\LaravelDiskMonitor\Tests;

use Illuminate\Routing\Route;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelDiskMonitor\LaravelDiskMonitorServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\LaravelDiskMonitor\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        // register the new route
        // 3 test cases failed after adding new route
        //Route::diskMonitor('disk-monitor');
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelDiskMonitorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        
        $migration = include __DIR__.'/../database/migrations/create_laravel-disk-monitor_tables.php.stub';
        $migration->up();
        
    }
}
