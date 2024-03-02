<?php

namespace MadeForYou\FilamentPages\Filament\Resources;

use Exception;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use MadeForYou\FilamentPages\Filament\Resources\PageResource\Pages;
use MadeForYou\FilamentPages\Models\Page;

/**
 * ## Page resource
 * ____________________________________
 * @package made-foryou/filament-pages
 * @author Menno Tempelaar <menno@made-foryou.nl>
 */
class PageResource extends Resource
{
    /**
     * The related model class string.
     *
     * @var class-string<Model> | null
     */
    protected static ?string $model = Page::class;

    /**
     * Slug name which will be used within filament for generating
     * the urls.
     *
     * @var string|null
     */
    protected static ?string $slug = 'pages';

    /**
     * Navigation icon which will be used within the menu on the left side
     * for presenting this resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    /**
     * Form
     *
     * Generates the contents of the form part which is used for creating and
     * updating instances of this resource.
     *
     * @param Form $form
     *
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                TextInput::make('summary'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Page $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Page $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    /**
     * Table
     *
     * Generates the contents for the index table which is used for showing the current
     * instances of this resource.
     *
     * @param Table $table
     *
     * @return Table
     *
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Pagina naam')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Laatst gewijzigd op')
                    ->since()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->isDateTime()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Returns an array with the used pages for this resource within Filament.
     *
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    /**
     * The eloquent builder which will be used for any queries of this resource.
     *
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * Returns an array with every attribute that can be searched on.
     *
     * @return string[]
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
