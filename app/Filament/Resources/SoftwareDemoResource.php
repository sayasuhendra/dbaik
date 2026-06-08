<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareDemoResource\Pages\ManageSoftwareDemos;
use App\Models\SoftwareDemo;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SoftwareDemoResource extends Resource
{
    protected static ?string $model = SoftwareDemo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static ?string $navigationLabel = 'Software Demos';

    protected static ?string $modelLabel = 'Software Demo';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('icon')
                    ->default('💻')
                    ->required()
                    ->placeholder('Emoji or short SVG (e.g. 📊)'),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
                TextInput::make('demo_url')
                    ->url()
                    ->placeholder('https://your-demo.dbaik.com')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->rows(3),
                Textarea::make('mockup_code')
                    ->placeholder('Optional simulated HTML layout code to render in the client portal')
                    ->columnSpanFull()
                    ->rows(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('icon')
                    ->alignCenter()
                    ->width('60px'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('demo_url')
                    ->limit(30),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSoftwareDemos::route('/'),
        ];
    }
}
