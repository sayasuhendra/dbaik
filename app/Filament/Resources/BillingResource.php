<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillingResource\Pages\ManageBillings;
use App\Models\Billing;
use App\Services\WhatsAppService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BillingResource extends Resource
{
    protected static ?string $model = Billing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Billings & Invoices';

    protected static ?string $modelLabel = 'Billing';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->placeholder('Monthly Hosting & Maintenance'),
                TextInput::make('amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                Select::make('billing_cycle')
                    ->options([
                        'one-time' => 'One-time',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ])
                    ->default('monthly')
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                DatePicker::make('due_date')
                    ->required(),
                Toggle::make('recurring_billing')
                    ->default(true)
                    ->required(),
                TextInput::make('whatsapp_number')
                    ->tel()
                    ->placeholder('e.g., 628170200885 (empty defaults to user email/details)'),
                Placeholder::make('last_reminder_sent_at')
                    ->content(fn ($record) => $record?->last_reminder_sent_at?->format('d M Y H:i:s') ?? 'Never sent'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('idr', locale: 'id_ID')
                    ->sortable(),
                TextColumn::make('billing_cycle')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'one-time' => 'gray',
                        'monthly' => 'info',
                        'yearly' => 'warning',
                        default => 'primary',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'overdue' => 'danger',
                        'cancelled' => 'gray',
                        default => 'primary',
                    })
                    ->sortable(),
                TextColumn::make('due_date')
                    ->date('d M Y')
                    ->sortable(),
                IconColumn::make('recurring_billing')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('last_reminder_sent_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Manual WhatsApp send action inside row
                Action::make('sendWhatsApp')
                    ->label('WhatsApp Reminder')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->action(function (Billing $record) {
                        $whatsappService = app(WhatsAppService::class);
                        $recipientNumber = $record->whatsapp_number ?: $record->user->whatsapp_number ?? null;

                        if (! $recipientNumber) {
                            Notification::make()
                                ->title('Warning')
                                ->body("No WhatsApp number configured for Billing #{$record->id} or Client {$record->user->name}.")
                                ->warning()
                                ->send();

                            return;
                        }

                        $formattedAmount = number_format($record->amount, 0, ',', '.');
                        $dueDateFormatted = $record->due_date->format('d M Y');
                        $cycle = ucfirst($record->billing_cycle);
                        $statusText = strtoupper($record->status);
                        $portalUrl = url('/client/portal');

                        $message = "*PENGINGAT PEMBAYARAN - DBAIK DIGITAL AGENCY* 🤖\n\n".
                                   "Halo *{$record->user->name}*,\n\n".
                                   "Ini adalah tagihan pembayaran Anda di DBAIK Digital Agency.\n\n".
                                   "*Detail Tagihan:*\n".
                                   "• *Layanan:* {$record->title}\n".
                                   "• *Jumlah:* Rp {$formattedAmount} ({$cycle})\n".
                                   "• *Jatuh Tempo:* {$dueDateFormatted}\n".
                                   "• *Status:* {$statusText}\n\n".
                                   "Mohon segera lakukan pembayaran via Portal Klien kami di:\n".
                                   "🔗 {$portalUrl}\n\n".
                                   "Terima kasih atas kepercayaan Anda!\n\n".
                                   "*DBAIK Digital Agency*\n".
                                   '_Silicon Valley Level AI & Technology Partner_';

                        $result = $whatsappService->sendMessage($recipientNumber, $message, $record);

                        if ($result['success']) {
                            Notification::make()
                                ->title('Success')
                                ->body("WhatsApp reminder successfully dispatched (Status: {$result['status']})")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error')
                                ->body('Failed to dispatch WhatsApp message.')
                                ->danger()
                                ->send();
                        }
                    }),
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
            'index' => ManageBillings::route('/'),
        ];
    }
}
