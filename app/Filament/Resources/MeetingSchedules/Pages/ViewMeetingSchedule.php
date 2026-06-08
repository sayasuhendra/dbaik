<?php

namespace App\Filament\Resources\MeetingSchedules\Pages;

use App\Filament\Resources\MeetingSchedules\MeetingScheduleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeetingSchedule extends ViewRecord
{
    protected static string $resource = MeetingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
