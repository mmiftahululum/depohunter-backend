<?php

namespace App\Filament\Resources\DepositProductResource\Pages;

use App\Filament\Resources\DepositProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepositProducts extends ListRecords
{
    protected static string $resource = DepositProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(function () {
                    $bankId = request()->input('tableFilters.bank_id.value');
                    if ($bankId) {
                        return DepositProductResource::getUrl('create', ['bank_id' => $bankId]);
                    }
                    return DepositProductResource::getUrl('create');
                }),
        ];
    }
}
