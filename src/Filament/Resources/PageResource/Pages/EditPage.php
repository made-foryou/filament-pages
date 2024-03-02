<?php

namespace MadeForYou\FilamentPages\Filament\Resources\PageResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use MadeForYou\FilamentPages\Filament\Resources\PageResource;

/**
 * ## Edit page
 * ____________________________________
 * @package made-foryou/filament-pages
 * @author Menno Tempelaar <menno@made-foryou>
 */
final class EditPage extends EditRecord
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
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
