<?php

namespace App\Filament\Resources\BillingResource\Pages;

use App\Filament\Resources\BillingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBillings extends ManageRecords
{
    protected static string $resource = BillingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
