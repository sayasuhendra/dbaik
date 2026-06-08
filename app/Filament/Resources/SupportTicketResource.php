<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportTicketResource\Pages\ManageSupportTickets;
use App\Models\SupportTicket;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Support Tickets';

    protected static ?string $modelLabel = 'Support Ticket';

    protected static ?string $recordTitleAttribute = 'subject';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subject')
                    ->required()
                    ->disabled(fn ($record) => $record !== null),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->disabled(fn ($record) => $record !== null)
                    ->label('Client'),
                Select::make('category')
                    ->options([
                        'technical' => 'Technical Support',
                        'billing' => 'Billing & Payment',
                        'general' => 'General Inquiry',
                    ])
                    ->default('general')
                    ->required()
                    ->disabled(fn ($record) => $record !== null),
                Select::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->default('medium')
                    ->required(),
                Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ])
                    ->default('open')
                    ->required(),

                Repeater::make('supportMessages')
                    ->relationship('supportMessages')
                    ->schema([
                        Placeholder::make('sender')
                            ->label('Sender')
                            ->content(function ($record) {
                                if (! $record) {
                                    return '✍️ Draft Reply';
                                }
                                $role = $record->is_admin ? '🛡️ Admin' : '👤 Client';
                                $senderName = $record->user->name ?? 'System';
                                $time = $record->created_at ? $record->created_at->format('d M Y H:i') : 'Just now';

                                return "{$role} ({$senderName}) — {$time}";
                            }),
                        Textarea::make('message')
                            ->required()
                            ->rows(3)
                            ->placeholder('Type your reply here...')
                            ->disabled(fn ($record) => $record !== null) // Prevent changing sent messages
                            ->columnSpanFull(),
                        Hidden::make('user_id')
                            ->default(fn () => auth()->id()),
                        Hidden::make('is_admin')
                            ->default(true),
                    ])
                    ->itemLabel(fn (array $state): ?string => ($state['is_admin'] ?? false) ? '🛡️ Admin Reply' : '👤 Client Message')
                    ->columnSpanFull()
                    ->deletable(false)
                    ->addable(fn ($record) => $record !== null) // Only allow adding replies to existing tickets
                    ->reorderable(false)
                    ->addActionLabel('Reply to Ticket'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'technical' => 'danger',
                        'billing' => 'warning',
                        'general' => 'info',
                        default => 'primary',
                    }),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'gray',
                        default => 'primary',
                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'gray',
                        default => 'primary',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->label('View & Reply'),
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
            'index' => ManageSupportTickets::route('/'),
        ];
    }
}
