<?php

namespace App\Filament\Resources\DepositRateResource\Pages;

use App\Filament\Resources\DepositRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepositRates extends ListRecords
{
    protected static string $resource = DepositRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
