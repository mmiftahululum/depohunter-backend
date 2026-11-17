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
            Actions\CreateAction::make()
                ->url(function () {
                    $productId = request()->input('tableFilters.deposit_product_id.value');
                    if ($productId) {
                        $product = \App\Models\DepositProduct::find($productId);
                        $bankId = $product ? $product->bank_id : null;
                        return DepositRateResource::getUrl('create', [
                            'deposit_product_id' => $productId,
                            'bank_filter' => $bankId
                        ]);
                    }
                    return DepositRateResource::getUrl('create');
                }),
        ];
    }
}
