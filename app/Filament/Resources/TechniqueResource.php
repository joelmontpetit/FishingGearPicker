<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechniqueResource\Pages;
use App\Models\Technique;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TechniqueResource extends Resource
{
    protected static ?string $model = Technique::class;

    protected static ?string $navigationLabel = 'Techniques';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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

                Forms\Components\Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),

                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

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
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTechniques::route('/'),
            'create' => Pages\CreateTechnique::route('/create'),
            'edit' => Pages\EditTechnique::route('/{record}/edit'),
        ];
    }
}

