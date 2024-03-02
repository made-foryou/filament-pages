<?php

namespace MadeForYou\FilamentPages\Filament\Resources\PageResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\CreateRecord;
use MadeForYou\FilamentPages\Filament\Resources\PageResource;

/**
 * ## Create page
 * ____________________________________
 * @package made-foryou/filament-pages
 * @author Menno Tempelaar <menno@made-foryou>
 */
final class CreatePage extends CreateRecord
{
    /**
     * Resource class which this page is related to.
     *
     * @var string<class-string<Resource>>
     */
    protected static string $resource = PageResource::class;

    /**
     * Returns an array with the actions which will be used within the
     * header of this page.
     *
     * @return array|Action[]|ActionGroup[]
     */
    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
