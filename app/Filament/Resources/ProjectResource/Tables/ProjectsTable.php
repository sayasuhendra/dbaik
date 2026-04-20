<?php

namespace App\Filament\Resources\ProjectResource\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('category'),
                TextColumn::make('location'),
                ImageColumn::make('photos')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
