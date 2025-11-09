<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliateLinkResource\Pages;
use App\Models\AffiliateLink;
use App\Models\Product;
use App\Models\Store;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class AffiliateLinkResource extends Resource
{
    protected static ?string $model = AffiliateLink::class;

    protected static ?string $navigationLabel = 'Affiliate Links';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->options(Product::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('store_id')
                    ->label('Store')
                    ->options(Store::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('affiliate_url')
                    ->label('Affiliate URL')
                    ->required()
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                Forms\Components\Toggle::make('in_stock')
                    ->label('In Stock')
                    ->default(true),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),

                Forms\Components\DateTimePicker::make('last_checked_at')
                    ->label('Last Checked'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('store.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name'),

                Tables\Filters\SelectFilter::make('store_id')
                    ->label('Store')
                    ->relationship('store', 'name'),

                Tables\Filters\SelectFilter::make('in_stock')
                    ->options([
                        1 => 'In Stock',
                        0 => 'Out of Stock',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAffiliateLinks::route('/'),
            'create' => Pages\CreateAffiliateLink::route('/create'),
            'edit' => Pages\EditAffiliateLink::route('/{record}/edit'),
        ];
    }
}
