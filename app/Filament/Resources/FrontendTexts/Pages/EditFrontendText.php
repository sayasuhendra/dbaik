<?php

namespace App\Filament\Resources\FrontendTexts\Pages;

use App\Filament\Resources\FrontendTexts\FrontendTextResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFrontendText extends EditRecord
{
    protected static string $resource = FrontendTextResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
