<?php

namespace MadeForYou\FilamentPages\Filament\Resources;

use Exception;
use Filament\Forms\Components\Builder as FormBuilder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section as InfoListSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
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
use Filament\Tables\Columns\ToggleColumn;
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
 *
 * @package made-foryou/filament-pages
 * @author  Menno Tempelaar <menno@made-foryou.nl>
 */
final class PageResource
    extends Resource
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
     * @param  Form  $form
     *
     * @return Form
     */
    public static function form ( Form $form ): Form
    {
        return $form
            ->schema( [
                Section::make( __( 'Pagina' ) )
                    ->description( __( 'Basis informatie van de pagina.' ) )
                    ->aside()
                    ->columns( [
                        'sm' => 1,
                    ] )
                    ->schema( [
                        TextInput::make( 'name' )
                            ->label( __( 'Pagina naam' ) )
                            ->required(),

                        TextInput::make( 'summary' )
                            ->label( __( 'Introductie' ) )
                            ->helperText(
                                __(
                                    "Een korte samenvattende introductie over de inhoud van de pagina."
                                )
                            )
                            ->nullable(),

                        Toggle::make( 'in_menu' )
                            ->label( 'Tonen in het menu?' ),
                    ] ),

                Section::make( heading: 'Inhoud' )
                    ->description( description: 'Pagina inhoud van het bericht' )
                    ->columns( columns: [
                        'sm' => 1,
                    ] )
                    ->collapsible()
                    ->schema( components: [
                        FormBuilder::make( name: 'content' )
                            ->label( __( 'Pagina inhoud' ) )
                            ->blocks( self::getContentBlocks() )
                            ->reorderable()
                            ->collapsible(),
                    ] ),
            ] );
    }

    /**
     * Gathers the content block components from the configuration.
     *
     * @return array<int, Block>
     */
    public static function getContentBlocks (): array
    {
        return collect( config( 'made-filament-pages.content_blocks' ) )
            ->map( fn ( string $block ) => ( new $block )->getBlock() )
            ->toArray();
    }

    /**
     * The eloquent builder which will be used for any queries of this resource.
     *
     * @return Builder
     */
    public static function getEloquentQuery (): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes( [
                SoftDeletingScope::class,
            ] );
    }

    /**
     * Returns an array with every attribute that can be searched on.
     *
     * @return string[]
     */
    public static function getGloballySearchableAttributes (): array
    {
        return [ 'name' ];
    }

    /**
     * Returns an array with the used pages for this resource within Filament.
     *
     * @return array|PageRegistration[]
     */
    public static function getPages (): array
    {
        return [
            'index' => Pages\ListPages::route( '/' ),
            'create' => Pages\CreatePage::route( '/create' ),
            'view' => Pages\ViewPage::route( '/{record}' ),
            'edit' => Pages\EditPage::route( '/{record}/edit' ),
        ];
    }

    /**
     * Info list
     *
     * Generates the contents for the detail view page of this resource.
     *
     * @param  Infolist  $infolist  The info list to configure.
     *
     * @return Infolist The configured info list.
     *
     * @throws Exception
     */
    public static function infolist ( Infolist $infolist ): Infolist
    {
        return $infolist->schema( [
            Grid::make( [
                'sm' => 1,
            ] )
                ->schema( [
                    InfoListSection::make( __( 'Pagina' ) )
                        ->description( __( 'Basis informatie van de pagina.' ) )
                        ->aside()
                        ->schema( [
                            Grid::make( 2 )
                                ->schema( [
                                    TextEntry::make( 'name' )
                                        ->label( __( 'Pagina naam' ) ),

                                    TextEntry::make( 'summary' )
                                        ->label( __( 'Introductie' ) )
                                        ->helperText(
                                            __(
                                                "Een korte samenvattende introductie over de inhoud van de pagina."
                                            )
                                        ),

                                    TextEntry::make( 'in_menu' )
                                        ->label( __( 'Menu' ) )
                                        ->badge()
                                        ->color(
                                            fn ( bool $value ) => $value ? 'success' : 'warning'
                                        )
                                        ->formatStateUsing(
                                            fn ( bool $value ) => $value ? __(
                                                'Zichtbaar in het menu'
                                            ) : __( 'Niet zichtbaar in het menu' )
                                        ),

                                    TextEntry::make( 'url' )
                                        ->label( 'URL' )
                                        ->html()
                                        ->state( function ( Page $record ) {
                                            return '<a href="'
                                                . url( $record->getUrl() )
                                                . '">'
                                                . $record->getUrl()
                                                . '</a>';
                                        } ),
                                ] ),
                        ] ),

                    InfoListSection::make( __( 'Administratie' ) )
                        ->description(
                            __( 'Belangrijke gegevens voor de ontwikkelaars van de categorie.' )
                        )
                        ->aside()
                        ->schema( [
                            TextEntry::make( 'id' )
                                ->label( __( 'ID' ) )
                                ->numeric(),

                            TextEntry::make( 'created_at' )
                                ->label( __( 'Aangemaakt op' ) )
                                ->dateTime(),

                            TextEntry::make( 'updated_at' )
                                ->label( __( 'Laatst gewijzigd op' ) )
                                ->since(),

                            TextEntry::make( 'deleted_at' )
                                ->label( __( 'Verwijderd op' ) )
                                ->dateTime(),
                        ] ),
                ] ),
        ] );
    }

    /**
     * Table
     *
     * Generates the contents for the index table which is used for showing the current
     * instances of this resource.
     *
     * @param  Table  $table
     *
     * @return Table
     *
     * @throws Exception
     */
    public static function table ( Table $table ): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'name' )
                    ->label( 'Pagina naam' )
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make( 'in_menu' )
                    ->label( 'Tonen in het menu?' ),

                TextColumn::make( 'updated_at' )
                    ->label( 'Laatst gewijzigd op' )
                    ->since()
                    ->sortable(),

                TextColumn::make( 'created_at' )
                    ->label( 'Aangemaakt op' )
                    ->date()
                    ->sortable(),
            ] )
            ->filters( [
                TrashedFilter::make(),
            ] )
            ->actions( [
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ] )
            ->bulkActions( [
                BulkActionGroup::make( [
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ] ),
            ] );
    }

}
