<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BuildResource\Pages;
use App\Models\Build;
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
