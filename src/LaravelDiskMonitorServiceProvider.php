<?php

namespace Spatie\LaravelDiskMonitor;

use Illuminate\Routing\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelDiskMonitor\Commands\RecordDiskMetricsCommand;
use Spatie\LaravelDiskMonitor\Http\Controllers\DiskMetricsController;

class LaravelDiskMonitorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-disk-monitor')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-disk-monitor_tables')
            ->hasCommand(RecordDiskMetricsCommand::class);
    }


    public function boot() {
        //dd('LaravelDiskMonitorServiceProvider.boot() starts...');

        parent::boot();

        // add a route macro
        // it should be added in boot() method
        //dd('here');
        /*
        Route::marco('diskMonitor', function (string $prefix) {
            Route::prefix($prefix)->group(function () {
                Route::get('/', DiskMetricsController::class);
            });
        });
        */

    }

}
