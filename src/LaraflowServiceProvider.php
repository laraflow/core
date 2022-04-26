<?php

namespace Laraflow\Laraflow;

use Laraflow\Laraflow\Commands\LaraflowCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaraflowServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laraflow')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laraflow_table')
            ->hasCommand(LaraflowCommand::class);
    }
}
