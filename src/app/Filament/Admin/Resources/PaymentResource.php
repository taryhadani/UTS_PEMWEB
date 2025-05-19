<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PaymentResource\Pages;
use App\Models\Payment;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pembayaran';
    protected static ?string $pluralModelLabel = 'Pembayaran';
    protected static ?string $modelLabel = 'Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Produk')
                    ->options(Product::all()->pluck('nama_produk', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_pembayaran')
                    ->label('Tanggal Pembayaran')
                    ->required(),

                Forms\Components\Select::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->options([
                        'Transfer' => 'Transfer',
                        'Kartu Kredit' => 'Kartu Kredit',
                        'Tunai' => 'Tunai',
                        'E-Wallet' => 'E-Wallet',
                    ])
                    ->required(),

                Forms\Components\Select::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->options([
                        'Pending' => 'Pending',
                        'Lunas' => 'Lunas',
                        'Gagal' => 'Gagal',
                    ])
                    ->default('Pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.nama_produk')
                    ->label('Produk')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_pembayaran')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Metode'),

                Tables\Columns\BadgeColumn::make('status_pembayaran')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'Pending' => 'Pending',
                    'Lunas' => 'Lunas',
                    'Gagal' => 'Gagal',
                    default => $state,
                })
                ->color(fn (string $state): string => match ($state) {
                    'Pending' => 'warning',
                    'Lunas' => 'success',
                    'Gagal' => 'danger',
                    default => 'gray',
                })
                
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Lunas' => 'Lunas',
                        'Gagal' => 'Gagal',
                    ]),
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
            // Tambahkan RelationManager jika ada relasi lainnya
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
