<?php

namespace App\Filament\Resources\MeetingSchedules\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MeetingScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_name'),
                TextEntry::make('client_email'),
                TextEntry::make('client_phone'),
                TextEntry::make('topic'),
                TextEntry::make('meeting_date')
                    ->date(),
                TextEntry::make('meeting_time')
                    ->time(),
                TextEntry::make('status'),
                TextEntry::make('meeting_link')
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
