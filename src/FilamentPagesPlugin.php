<?php

namespace MadeForYou\FilamentPages;

use Filament\Contracts\Plugin;
use Filament\Panel;
use MadeForYou\FilamentPages\Filament\Resources\PageResource;

/**
 * ## Filament pages plugin
 * ______________________________________________________________
 * @package made-foryou/filament-pages
 * @author Menno Tempelaar <menno@made-foryou.nl>
 */
class FilamentPagesPlugin implements Plugin
{
    /**
     * Returns the name / id of the plugin.
     *
     * @return string
     */
    #[\Override] public function getId(): string
    {
        return FilamentPagesServiceProvider::$name;
    }

    /**
     * Registers the tools needed for this plugin within Filament.
     *
     * @param Panel $panel
     *
     * @return void
     */
    #[\Override] public function register(Panel $panel): void
    {
        $panel->resources([
            PageResource::class,
        ]);
    }

    /**
     * Boots the plugin within Filament.
     *
     * @param Panel $panel
     *
     * @return void
     */
    #[\Override] public function boot(Panel $panel): void
    {
        //
    }
}
