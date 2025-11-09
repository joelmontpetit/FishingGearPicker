<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoMetaResource\Pages;
use App\Models\Build;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\SeoMeta;
use App\Models\Species;
use App\Models\Technique;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SeoMetaResource extends Resource
{
    protected static ?string $model = SeoMeta::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Page Identification')
                    ->schema([
                        Forms\Components\Select::make('page_type')
                            ->label('Page Type')
                            ->options([
                                'home' => 'Home Page',
                                'techniques-index' => 'Techniques Index',
                                'technique' => 'Technique Detail',
                                'species-index' => 'Species Index',
                                'species' => 'Species Detail',
                                'build' => 'Build Detail',
                                'product' => 'Product Detail',
                                'product_type' => 'Product Type',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                // Auto-générer le slug pour les pages index
                                if (in_array($state, ['home', 'techniques-index', 'species-index'])) {
                                    $set('slug', $state);
                                    $set('entity_id', null);
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('Pour les pages statiques (home, index)')
                            ->visible(fn ($get) => in_array($get('page_type'), ['home', 'techniques-index', 'species-index']))
                            ->disabled(),

                        Forms\Components\Select::make('entity_id')
                            ->label('Select Entity')
                            ->options(function ($get) {
                                return match ($get('page_type')) {
                                    'technique' => Technique::pluck('name', 'id'),
                                    'species' => Species::pluck('name', 'id'),
                                    'build' => Build::all()->pluck(function ($build) {
                                        return $build->name . ' (' . $build->technique->name . ')';
                                    }, 'id'),
                                    'product' => Product::all()->pluck(function ($product) {
                                        return $product->name . ' (' . $product->brand . ')';
                                    }, 'id'),
                                    'product_type' => ProductType::pluck('name', 'id'),
                                    default => [],
                                };
                            })
                            ->searchable()
                            ->visible(fn ($get) => !in_array($get('page_type'), ['home', 'techniques-index', 'species-index']))
                            ->helperText('Select the specific entity for this SEO meta'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Meta Tags')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Optimal: 50-60 characters')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Optimal: 150-160 characters')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->rows(2)
                            ->helperText('Comma-separated keywords')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Open Graph / Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('og_title')
                            ->label('OG Title')
                            ->helperText('Leave empty to use Meta Title')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('og_description')
                            ->label('OG Description')
                            ->rows(2)
                            ->helperText('Leave empty to use Meta Description')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('og_image')
                            ->label('OG Image URL')
                            ->url()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('twitter_card')
                            ->label('Twitter Card Type')
                            ->options([
                                'summary' => 'Summary',
                                'summary_large_image' => 'Summary Large Image',
                            ])
                            ->default('summary_large_image'),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive metas will not be used'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_type')
                    ->label('Page Type')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug/Entity')
                    ->getStateUsing(function ($record) {
                        if ($record->slug) {
                            return $record->slug;
                        }
                        // Afficher le nom de l'entité si applicable
                        return match ($record->page_type) {
                            'technique' => Technique::find($record->entity_id)?->name ?? "ID: {$record->entity_id}",
                            'species' => Species::find($record->entity_id)?->name ?? "ID: {$record->entity_id}",
                            'build' => Build::find($record->entity_id)?->name ?? "ID: {$record->entity_id}",
                            'product' => Product::find($record->entity_id)?->name ?? "ID: {$record->entity_id}",
                            'product_type' => ProductType::find($record->entity_id)?->name ?? "ID: {$record->entity_id}",
                            default => '-',
                        };
                    })
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('meta_title')
                    ->label('Meta Title')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('page_type')
                    ->options([
                        'home' => 'Home Page',
                        'techniques-index' => 'Techniques Index',
                        'technique' => 'Technique Detail',
                        'species-index' => 'Species Index',
                        'species' => 'Species Detail',
                        'build' => 'Build Detail',
                        'product' => 'Product Detail',
                        'product_type' => 'Product Type',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeoMetas::route('/'),
            'create' => Pages\CreateSeoMeta::route('/create'),
            'edit' => Pages\EditSeoMeta::route('/{record}/edit'),
        ];
    }
}

