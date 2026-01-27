<?php

namespace App\Filament\Resources\DepositRateResource\Pages;

use App\Filament\Resources\DepositRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepositRate extends EditRecord
{
    protected static string $resource = DepositRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
