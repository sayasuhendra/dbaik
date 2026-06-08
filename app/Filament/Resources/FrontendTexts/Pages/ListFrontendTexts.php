<?php

namespace App\Filament\Resources\FrontendTexts\Pages;

use App\Filament\Resources\FrontendTexts\FrontendTextResource;
use Filament\Resources\Pages\ListRecords;

class ListFrontendTexts extends ListRecords
{
    protected static string $resource = FrontendTextResource::class;

    public function mount(): void
    {
        parent::mount();

        if ($record = $this->getModel()::first()) {
            redirect(static::getResource()::getUrl('edit', ['record' => $record]));
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
