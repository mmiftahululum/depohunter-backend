<?php

namespace App\Filament\Resources\DepositRateResource\Pages;

use App\Filament\Resources\DepositRateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepositRate extends CreateRecord
{
    protected static string $resource = DepositRateResource::class;

    public ?string $preservedBankFilter = null;
    public ?string $preservedProductId = null;

    protected function beforeCreate(): void
    {
        $raw = $this->form->getRawState();
        $this->preservedBankFilter = $raw['bank_filter'] ?? null;
        $this->preservedProductId = $raw['deposit_product_id'] ?? null;
    }

    protected function afterFill(): void
    {
        if ($this->preservedBankFilter) {
            $this->data['bank_filter'] = $this->preservedBankFilter;
        }
        if ($this->preservedProductId) {
            $this->data['deposit_product_id'] = $this->preservedProductId;
        }
    }
}
