<?php

namespace App\Filament\Resources\MeetingSchedules\Pages;

use App\Filament\Resources\MeetingSchedules\MeetingScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeetingSchedules extends ListRecords
{
    protected static string $resource = MeetingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
