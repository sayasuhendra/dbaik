<?php

namespace App\Filament\Resources\MeetingSchedules\Pages;

use App\Filament\Resources\MeetingSchedules\MeetingScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMeetingSchedule extends EditRecord
{
    protected static string $resource = MeetingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
