<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Store;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'Products';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('product_type_id')
                    ->label('Product Type')
                    ->options(ProductType::pluck('name', 'id'))
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

                Forms\Components\TextInput::make('brand')
                    ->maxLength(255),

                Forms\Components\TextInput::make('model')
                    ->maxLength(255),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\KeyValue::make('specifications')
                    ->keyLabel('Spec Name')
                    ->valueLabel('Spec Value')
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),

                Forms\Components\TextInput::make('popularity_score')
                    ->numeric()
                    ->default(0),

                Forms\Components\KeyValue::make('meta_tags')
                    ->keyLabel('Meta Key')
                    ->valueLabel('Meta Value')
                    ->columnSpanFull(),

                Forms\Components\Placeholder::make('affiliate_links_header')
                    ->label('Affiliate Links')
                    ->content('Manage affiliate purchase links for this product from stores like Amazon, Bass Pro Shops, etc.')
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('affiliateLinks')
                    ->relationship('affiliateLinks')
                    ->schema([
                        Forms\Components\Select::make('store_id')
                            ->label('Store')
                            ->options(Store::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('affiliate_url')
                            ->label('Affiliate URL')
                            ->url()
                            ->required()
                            ->maxLength(500)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('price')
                            ->label('Price at Store')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(5)
                    ->defaultItems(0)
                    ->addActionLabel('Add Affiliate Link')
                    ->reorderable(false)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => 
                        Store::find($state['store_id'])?->name ?? 'New Link'
                    )
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
                    ->limit(40),

                Tables\Columns\TextColumn::make('productType.name')
                    ->label('Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_type_id')
                    ->label('Product Type')
                    ->relationship('productType', 'name'),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
