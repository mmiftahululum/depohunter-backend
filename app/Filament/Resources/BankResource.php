<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankResource\Pages;
use App\Filament\Resources\BankResource\RelationManagers;
use App\Models\Bank;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        TextInput::make('name')
            ->required()
            ->label('Nama Bank'),
            
        Select::make('type')
            ->options([
                'digital' => 'Bank Digital',
                'konvensional' => 'Bank Umum Konvensional',
                'bpr' => 'BPR (Bank Perekonomian Rakyat)',
            ])
            ->required(),

        FileUpload::make('logo_url')
            ->image() // Validasi harus gambar
            ->directory('bank-logos') // Disimpan di storage/app/public/bank-logos
            ->label('Logo Bank'),

        Toggle::make('is_lps_insured')
            ->label('Dijamin LPS?')
            ->default(true),
            
        Toggle::make('is_ojk_verified')
            ->label('Terdaftar OJK?')
            ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            // 1. Menampilkan Logo
            ImageColumn::make('logo_url')
                ->label('Logo')
                ->circular(), // Biar bulat (opsional)

            // 2. Menampilkan Nama Bank
            TextColumn::make('name')
                ->label('Nama Bank')
                ->searchable() // Agar bisa dicari di kolom search
                ->sortable(),  // Agar bisa diurutkan A-Z

            // 3. Menampilkan Tipe Bank
            TextColumn::make('type')
                ->badge() // Tampil seperti badge warna
                ->colors([
                    'primary' => 'digital',
                    'success' => 'konvensional',
                    'warning' => 'bpr',
                ]),

            // 4. Status OJK (Centang / Silang)
            IconColumn::make('is_ojk_verified')
                ->label('OJK')
                ->boolean(),

            // 5. Status LPS
            IconColumn::make('is_lps_insured')
                ->label('LPS')
                ->boolean(),
        ])
        ->filters([
            //
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
            'index' => Pages\ListBanks::route('/'),
            'create' => Pages\CreateBank::route('/create'),
            'edit' => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}
