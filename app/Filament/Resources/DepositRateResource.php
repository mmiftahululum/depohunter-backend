<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositRateResource\Pages;
use App\Filament\Resources\DepositRateResource\RelationManagers;
use App\Models\DepositRate;
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
use Filament\Tables\Filters\SelectFilter;
use App\Models\GlobalSetting;
use App\Models\Bank;
use App\Models\DepositProduct;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;


class DepositRateResource extends Resource
{
    protected static ?string $model = DepositRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
           ->schema([
        
                // 1. INPUT DUMMY: PILIH BANK
            Forms\Components\Select::make('bank_filter')
                ->label('Pilih Bank Terlebih Dahulu')
                ->options(Bank::query()->pluck('name', 'id'))
                ->live()
                ->dehydrated(false)
                ->searchable()
                ->preload()
                ->columnSpanFull()
                // --- TAMBAHKAN BAGIAN INI ---
                ->afterStateHydrated(function (Forms\Components\Select $component, ?DepositRate $record) {
                    // Logika: Jika sedang Edit (record ada), ambil bank_id dari produknya
                    if ($record && $record->product) {
                        $component->state($record->product->bank_id);
                    }
                }),
                // ----------------------------

            // 2. INPUT ASLI: PILIH PRODUK (Otomatis terfilter)
                Forms\Components\Select::make('deposit_product_id')
                ->label('Pilih Produk Deposito')
                ->options(function (Get $get, ?DepositRate $record) { // Tambahkan $record di parameter
                    $bankId = $get('bank_filter');

                    // Fallback: Jika bank_filter belum terdeteksi (kadang delay),
                    // tapi kita sedang edit data, ambil bank_id dari record
                    if (! $bankId && $record && $record->product) {
                        $bankId = $record->product->bank_id;
                    }

                    if ($bankId) {
                        return DepositProduct::where('bank_id', $bankId)
                            ->pluck('name', 'id');
                    }
                    
                    return [];
                })
                ->disabled(fn (Get $get) => ! $get('bank_filter') && ! ($get('deposit_product_id'))) // Tetap aktif jika sudah ada isinya
                ->required()
                ->searchable()
                ->preload(),

            Select::make('duration_months')
                ->options([
                    1 => '1 Bulan',
                    3 => '3 Bulan',
                    6 => '6 Bulan',
                    12 => '12 Bulan',
                ])
                ->required()
                ->label('Tenor (Durasi)'),

          Forms\Components\TextInput::make('interest_rate')
            ->numeric()
            ->suffix('%')
            ->step(0.01)
            ->required()
            ->label('Suku Bunga (p.a)')
            ->live(onBlur: true)
            ->afterStateUpdated(function (Get $get, Set $set, ?float $state) {
                if (!$state) return;

                // 1. Ambil ID Produk yang dipilih
                $productId = $get('deposit_product_id');
                if (!$productId) return;

                // 2. Cek Tipe Bank dari Produk tersebut
                $product = DepositProduct::with('bank')->find($productId);
                if (!$product || !$product->bank) return;
                
                $bankType = $product->bank->type; // 'digital', 'konvensional', atau 'bpr'

                // 3. Tentukan Batas LPS berdasarkan Tipe Bank
                // Jika BPR, ambil config batas BPR. Jika tidak, ambil config Bank Umum.
                $configKey = ($bankType === 'bpr') ? 'lps_limit_bpr' : 'lps_limit_general';
                
                // Ambil nilai dari tabel GlobalSetting
                $lpsLimit = GlobalSetting::where('key', $configKey)->value('value') ?? 4.25;

                // 4. Bandingkan Bunga Inputan vs Batas LPS
                // Jika Bunga > Batas, maka TIDAK DIJAMIN (False)
                if ($state > $lpsLimit) {
                    $set('is_lps_insured', false);
                } else {
                    $set('is_lps_insured', true);
                }
            }),

            TextInput::make('tax_percent')
                ->numeric()
                ->default(20)
                ->suffix('%')
                ->label('Pajak Bunga'),

                Forms\Components\Toggle::make('is_lps_insured')
                ->label('Dijamin LPS?')
                ->helperText('Otomatis mati jika bunga > batas LPS, tapi bisa diubah manual.')
                ->default(true)
                ->onColor('success') // Hijau kalau aktif
                ->offColor('danger'), // Merah kalau mati
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
            // 1. Nama Bank (Diambil dari relasi Rate -> Product -> Bank)
            TextColumn::make('product.bank.name')
                ->label('Bank')
                ->sortable()
                ->searchable(),

            // 2. Nama Produk
            TextColumn::make('product.name')
                ->label('Produk')
                ->searchable()
                ->limit(20), // Biar kolom tidak terlalu lebar

            // 3. Tenor (Durasi)
            TextColumn::make('duration_months')
                ->label('Tenor')
                ->suffix(' Bulan') // Menambah tulisan " Bulan" otomatis
                ->sortable()
                ->alignment('center'),

            // 4. Bunga (Highlight Utama)
            TextColumn::make('interest_rate')
                ->label('Bunga (p.a)')
                ->suffix('%')
                ->sortable()
                ->weight('bold') // Tebal biar menonjol
                ->color(fn (string $state): string => $state > 5 ? 'success' : 'primary'), 
                // Logika warna: Kalau bunga > 5% jadi Hijau (Success), kalau tidak Biru (Primary)

            // 5. Pajak
            TextColumn::make('tax_percent')
                ->label('Pajak')
                ->suffix('%')
                ->toggleable(isToggledHiddenByDefault: true), // Default disembunyikan biar tabel tidak penuh
        ])
        ->defaultSort('interest_rate', 'desc') // Otomatis urutkan dari Bunga Tertinggi saat dibuka
        ->filters([
            // Filter Berdasarkan Tenor
            SelectFilter::make('duration_months')
                ->label('Filter Tenor')
                ->options([
                    1 => '1 Bulan',
                    3 => '3 Bulan',
                    6 => '6 Bulan',
                    12 => '12 Bulan',
                ]),

            // 2. Filter Bank (Baru)
            SelectFilter::make('bank_filter') // Nama dummy saja
                ->label('Filter Bank')
                ->options(Bank::query()->pluck('name', 'id')) // Ambil list semua bank
                ->searchable() // Biar bisa ketik nama bank
                ->preload()
                ->query(function (Builder $query, array $data) {
                    // Logika: Jika user memilih bank (value ada isinya)
                    if (!empty($data['value'])) {
                        // Cari Rate yang punya Produk, dimana Produk tersebut punya Bank ID sesuai pilihan
                        $query->whereHas('product', function (Builder $q) use ($data) {
                            $q->where('bank_id', $data['value']);
                        });
                    }
                }),

            // 3. Filter Produk (Baru)
            SelectFilter::make('deposit_product_id')
                ->label('Filter Produk')
                ->relationship('product', 'name') // Relasi langsung
                ->searchable()
                ->preload(),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepositRates::route('/'),
            'create' => Pages\CreateDepositRate::route('/create'),
            'edit' => Pages\EditDepositRate::route('/{record}/edit'),
        ];
    }
}
