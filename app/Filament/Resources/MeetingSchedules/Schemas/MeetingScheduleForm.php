<?php

namespace App\Filament\Resources\MeetingSchedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class MeetingScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_name')
                    ->required(),
                TextInput::make('client_email')
                    ->email()
                    ->required(),
                TextInput::make('client_phone')
                    ->tel()
                    ->required(),
                TextInput::make('topic')
                    ->required(),
                DatePicker::make('meeting_date')
                    ->required(),
                TimePicker::make('meeting_time')
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ])
                    ->required()
                    ->default('pending'),
                TextInput::make('meeting_link')
                    ->url()
                    ->placeholder('e.g. https://meet.google.com/...'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
