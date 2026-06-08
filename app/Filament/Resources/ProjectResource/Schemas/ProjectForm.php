<?php

namespace App\Filament\Resources\ProjectResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('category'),
                TextInput::make('location'),
                TextInput::make('year'),
                TextInput::make('type'),
                Toggle::make('is_active')
                    ->label('Active / Show')
                    ->default(true),

                Repeater::make('description')
                    ->schema([
                        TextInput::make('line')
                            ->hiddenLabel()
                            ->required(),
                    ])
                    ->columnSpanFull(),

                FileUpload::make('photos')
                    ->multiple()
                    ->image()
                    ->directory('projects')
                    ->columnSpanFull(),
            ]);
    }
}
