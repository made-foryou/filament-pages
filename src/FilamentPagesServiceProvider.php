<?php

namespace MadeForYou\FilamentPages;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * ## Filament page service provider
 * ______________________________________
 *
 * @author Menno Tempelaar <menno@made-foryou.nl>
 */
final class FilamentPagesServiceProvider extends PackageServiceProvider
{
    /**
     * The name of this package.
     */
    public static string $name = 'made-filament-pages';

    /**
     * Configures the package for Laravel.
     */
    #[\Override]
    public function configurePackage(
        Package $package
    ): void {
        $package->name(self::$name)
            ->hasConfigFile()
            ->hasMigrations([
                'create_pages_table',
                'add_in_menu_column_to_pages_table',
                'add_meta_column_to_pages_table',
            ])
            ->hasInstallCommand(function (InstallCommand $installCommand) {
                $installCommand->startWith(
                    fn (InstallCommand $command) => $command->info(
                        'Let\'s install the Made for you filament pages package.'
                    )
                )
                    ->publishConfigFile()
                    ->publishMigrations();
            });
    }
}
