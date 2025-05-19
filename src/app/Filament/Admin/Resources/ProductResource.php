<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $pluralModelLabel = 'Produk';
    protected static ?string $modelLabel = 'Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->maxLength(500)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('idr', true),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(30)
                    ->wrap(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Bisa tambahkan relasi jika ada (misalnya: pembayaran)
        ];
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
