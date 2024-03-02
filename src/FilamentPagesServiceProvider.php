<?php

namespace MadeForYou\FilamentPages;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

final class FilamentPagesServiceProvider extends PackageServiceProvider
{
	public static string $name = 'made-filament-pages';

	#[\Override] public function configurePackage(
		Package $package
	): void {
		$package->name(self::$name)
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $installCommand) {
                $installCommand->startWith(
                    fn (InstallCommand $command) => $command->info(
                        'Let\'s install the Made for you filament pages package.'
                    )
                )
                    ->publishConfigFile();
            });
	}
}
