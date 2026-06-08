<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages\ManageSiteSettings;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'hero_title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hero_title'),
                Textarea::make('hero_subtitle')
                    ->columnSpanFull(),
                TextInput::make('whatsapp_number'),
                TextInput::make('office_hours'),
                TextInput::make('location_text'),
                TextInput::make('location_url')
                    ->url()
                    ->helperText('Contoh: https://maps.app.goo.gl/...'),
                FileUpload::make('square_logo')
                    ->image()
                    ->disk('public')
                    ->directory('site-logos'),
                FileUpload::make('horizontal_logo')
                    ->image()
                    ->disk('public')
                    ->directory('site-logos'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('hero_title')
            ->columns([
                ImageColumn::make('square_logo'),
                ImageColumn::make('horizontal_logo'),
                TextColumn::make('hero_title')
                    ->searchable(),
                TextColumn::make('whatsapp_number')
                    ->searchable(),
                TextColumn::make('office_hours')
                    ->searchable(),
                TextColumn::make('location_text')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSiteSettings::route('/'),
        ];
    }
}
