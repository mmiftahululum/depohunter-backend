<?php

namespace App\Filament\Resources\GlobalSettingResource\Pages;

use App\Filament\Resources\GlobalSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGlobalSettings extends ListRecords
{
    protected static string $resource = GlobalSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
