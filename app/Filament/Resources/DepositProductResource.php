<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositProductResource\Pages;
use App\Filament\Resources\DepositProductResource\RelationManagers;
use App\Models\DepositProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload; // Untuk upload logo
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle; // Untuk on/off (OJK/LPS)
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter; // Kita tambah Filter biar keren

class DepositProductResource extends Resource
{
    protected static ?string $model = DepositProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
          ->schema([
            Select::make('bank_id')
                ->relationship('bank', 'name') // Mengambil daftar Bank otomatis
                ->searchable()
                ->preload()
                ->required()
                ->label('Nama Bank'),

            TextInput::make('name')
                ->required()
                ->label('Nama Produk (Misal: Deposito Wow)'),

            TextInput::make('min_deposit')
                ->numeric()
                ->prefix('Rp')
                ->label('Minimal Penempatan'),

            TextInput::make('referral_link')
                ->url()
                ->label('Link Referral (Affiliate)'),
                
            Toggle::make('is_active')
                ->label('Aktifkan Produk')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
            // 1. Relasi ke Nama Bank
            // Gunakan notasi titik (.) untuk ambil data dari tabel sebelah
            TextColumn::make('bank.name') 
                ->label('Bank')
                ->sortable() // Bisa urutkan A-Z berdasarkan nama bank
                ->searchable(), // Bisa cari nama bank di sini

            // 2. Nama Produk
            TextColumn::make('name')
                ->label('Nama Produk')
                ->searchable(),

            // 3. Minimal Penempatan (Format Rupiah)
            TextColumn::make('min_deposit')
                ->label('Min. Penempatan')
                ->money('IDR') // Otomatis format Rp 10.000.000
                ->sortable(),

            // 4. Status Aktif
            IconColumn::make('is_active')
                ->label('Aktif')
                ->boolean(),
                
            // 5. Link Referral (Opsional, kita potong biar gak kepanjangan)
            TextColumn::make('referral_link')
                ->label('Link')
                ->limit(20) // Cuma tampil 20 huruf pertama
                ->copyable() // User bisa klik untuk copy linknya
                ->icon('heroicon-m-link'), 
        ])
        ->filters([
            // Fitur Filter: Dropdown untuk memilih Bank tertentu saja
            SelectFilter::make('bank_id')
                ->relationship('bank', 'name')
                ->label('Filter per Bank'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepositProducts::route('/'),
            'create' => Pages\CreateDepositProduct::route('/create'),
            'edit' => Pages\EditDepositProduct::route('/{record}/edit'),
        ];
    }
}
