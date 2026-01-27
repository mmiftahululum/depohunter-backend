<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GlobalSettingResource\Pages;
use App\Filament\Resources\GlobalSettingResource\RelationManagers;
use App\Models\GlobalSetting;
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

class GlobalSettingResource extends Resource
{
    protected static ?string $model = GlobalSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label')
                ->disabled() // Label jangan diedit biar admin gak bingung
                ->columnSpanFull(),

            TextInput::make('value')
                ->label('Nilai (%)')
                ->numeric()
                ->step(0.01)
                ->suffix('%')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')->searchable(),
                TextColumn::make('value')->suffix('%')->sortable(),
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
            'index' => Pages\ListGlobalSettings::route('/'),
            'create' => Pages\CreateGlobalSetting::route('/create'),
            'edit' => Pages\EditGlobalSetting::route('/{record}/edit'),
        ];
    }
}
