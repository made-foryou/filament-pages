<?php

namespace MadeForYou\FilamentPages\Filament\Resources\PageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use MadeForYou\FilamentPages\Filament\Resources\PageResource;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
