<?php

namespace App\Filament\Resources\TestimonialResource\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('location'),
                TextColumn::make('stars')
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state)),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
