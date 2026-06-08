<?php

namespace App\Filament\Resources\SoftwareDemoResource\Pages;

use App\Filament\Resources\SoftwareDemoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSoftwareDemos extends ManageRecords
{
    protected static string $resource = SoftwareDemoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
