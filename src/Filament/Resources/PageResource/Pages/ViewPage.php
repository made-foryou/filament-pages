<?php

namespace MadeForYou\FilamentPages\Filament\Resources\PageResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use MadeForYou\FilamentPages\Filament\Resources\PageResource;

/**
 * ## View page
 * ____________________________________
 * @package made-foryou/filament-pages
 * @author Menno Tempelaar <menno@made-foryou>
 */
final class ViewPage extends ViewRecord
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
            EditAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
