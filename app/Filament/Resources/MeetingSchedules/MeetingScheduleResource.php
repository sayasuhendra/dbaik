<?php

namespace App\Filament\Resources\MeetingSchedules;

use App\Filament\Resources\MeetingSchedules\Pages\CreateMeetingSchedule;
use App\Filament\Resources\MeetingSchedules\Pages\EditMeetingSchedule;
use App\Filament\Resources\MeetingSchedules\Pages\ListMeetingSchedules;
use App\Filament\Resources\MeetingSchedules\Pages\ViewMeetingSchedule;
use App\Filament\Resources\MeetingSchedules\Schemas\MeetingScheduleForm;
use App\Filament\Resources\MeetingSchedules\Schemas\MeetingScheduleInfolist;
use App\Filament\Resources\MeetingSchedules\Tables\MeetingSchedulesTable;
use App\Models\MeetingSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MeetingScheduleResource extends Resource
{
    protected static ?string $model = MeetingSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MeetingScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MeetingScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeetingSchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeetingSchedules::route('/'),
            'create' => CreateMeetingSchedule::route('/create'),
            'view' => ViewMeetingSchedule::route('/{record}'),
            'edit' => EditMeetingSchedule::route('/{record}/edit'),
        ];
    }
}
