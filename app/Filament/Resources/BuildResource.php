<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BuildResource\Pages;
use App\Models\Build;
use App\Models\Product;
use App\Models\Species;
use App\Models\Technique;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BuildResource extends Resource
{
    protected static ?string $model = Build::class;

    protected static ?string $navigationLabel = 'Builds';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('technique_id')
                    ->label('Technique')
                    ->options(Technique::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('species_id')
                    ->label('Species')
                    ->options(Species::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::lower(Str::slug($state))))
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),

                Forms\Components\Select::make('budget_tier')
                    ->required()
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ])
                    ->default('beginner')
                    ->native(false),

                Forms\Components\Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                Forms\Components\Toggle::make('is_featured')
                    ->label('Featured Build'),

                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),

                Forms\Components\TextInput::make('views_count')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false),

                Forms\Components\KeyValue::make('meta_tags')
                    ->keyLabel('Meta Key')
                    ->valueLabel('Meta Value')
                    ->columnSpanFull(),

                Forms\Components\Section::make('Product Options')
                    ->description('Add multiple product options for each category. Users can choose between different price tiers.')
                    ->schema([
                        Forms\Components\Repeater::make('productOptions')
                            ->relationship('productOptions')
                            ->schema([
                                Forms\Components\Select::make('role')
                                    ->label('Product Role')
                                    ->options([
                                        'rod' => 'Rod',
                                        'reel' => 'Reel',
                                        'line' => 'Line',
                                        'lure' => 'Lure',
                                        'hook' => 'Hook',
                                        'weight' => 'Weight',
                                        'other' => 'Other',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(2),

                                Forms\Components\Select::make('product_id')
                                    ->label('Product')
                                    ->options(Product::where('is_active', true)->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(3),

                                Forms\Components\Select::make('price_tier')
                                    ->label('Price Tier')
                                    ->options([
                                        'budget' => '💰 Budget',
                                        'mid' => '💎 Mid-Range',
                                        'premium' => '⭐ Premium',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Order')
                                    ->numeric()
                                    ->default(0)
                                    ->required()
                                    ->columnSpan(1),

                                Forms\Components\Toggle::make('is_recommended')
                                    ->label('Recommended')
                                    ->default(false)
                                    ->columnSpan(1),

                                Forms\Components\Textarea::make('notes')
                                    ->label('Notes (optional)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(9)
                            ->defaultItems(0)
                            ->addActionLabel('Add Product Option')
                            ->reorderable(true)
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                isset($state['role']) && isset($state['price_tier']) 
                                    ? ucfirst($state['role']) . ' - ' . ucfirst($state['price_tier'])
                                    : null
                            ),
                    ])
                    ->columnSpanFull()
                    ->collapsed(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('technique.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('species.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('budget_tier')
                    ->badge()
                    ->colors([
                        'success' => 'beginner',
                        'warning' => 'intermediate',
                        'danger' => 'advanced',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('technique_id')
                    ->label('Technique')
                    ->relationship('technique', 'name'),

                Tables\Filters\SelectFilter::make('species_id')
                    ->label('Species')
                    ->relationship('species', 'name'),

                Tables\Filters\SelectFilter::make('budget_tier')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ]),

                Tables\Filters\SelectFilter::make('is_featured')
                    ->options([
                        1 => 'Featured',
                        0 => 'Not Featured',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBuilds::route('/'),
            'create' => Pages\CreateBuild::route('/create'),
            'edit' => Pages\EditBuild::route('/{record}/edit'),
        ];
    }
}
