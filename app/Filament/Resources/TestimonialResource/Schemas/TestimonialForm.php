<?php

namespace App\Filament\Resources\TestimonialResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('location'),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('avatar_char')
                    ->maxLength(1)
                    ->required(),
                Select::make('stars')
                    ->options([
                        1 => '1 Bintang',
                        2 => '2 Bintang',
                        3 => '3 Bintang',
                        4 => '4 Bintang',
                        5 => '5 Bintang',
                    ])
                    ->default(5)
                    ->required(),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
