<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LarametricsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('larametrics')
            ->hasConfigFile()
            ->hasViews()
            ->hasAssets()
            ->hasMigration('create_larametrics_table');
    }
}
