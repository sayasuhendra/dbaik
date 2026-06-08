<?php

namespace App\Console\Commands;

use App\Models\Billing;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBillingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:send-reminders {--force : Send reminders regardless of when the last reminder was sent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp billing reminders for recurring payments that are due soon or overdue';

    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        parent::__construct();
        $this->whatsappService = $whatsappService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting automated billing reminder process...');

        // Find bills that are due within 3 days or already overdue, and not paid yet
        $dueDateLimit = Carbon::now()->addDays(3);

        $billings = Billing::where('status', '!=', 'paid')
            ->where('due_date', '<=', $dueDateLimit)
            ->where('recurring_billing', true)
            ->with('user')
            ->get();

        if ($billings->isEmpty()) {
            $this->info('No billing reminders need to be sent today.');

            return 0;
        }

        $sentCount = 0;

        foreach ($billings as $billing) {
            // Throttle: don't send reminder if we already sent one in the last 24 hours (unless --force is used)
            if (! $this->option('force') && $billing->last_reminder_sent_at && $billing->last_reminder_sent_at->gt(Carbon::now()->subDay())) {
                $this->line("Skipped Billing #{$billing->id} for {$billing->user->name} - Reminder sent recently.");

                continue;
            }

            $recipientNumber = $billing->whatsapp_number ?: $billing->user->whatsapp_number ?? null;

            if (! $recipientNumber) {
                $this->error("Skipped Billing #{$billing->id} - No WhatsApp number provided for user {$billing->user->name}.");

                continue;
            }

            // Build WhatsApp message
            $formattedAmount = number_format($billing->amount, 0, ',', '.');
            $dueDateFormatted = $billing->due_date->format('d M Y');
            $cycle = ucfirst($billing->billing_cycle);
            $statusText = strtoupper($billing->status);
            $portalUrl = url('/client/portal');

            $message = "*PENGINGAT TAGIHAN RECURRING - DBAIK DIGITAL AGENCY* 🤖\n\n".
                       "Halo *{$billing->user->name}*,\n\n".
                       "Ini adalah pengingat ramah untuk pembayaran recurring layanan teknologi Anda di DBAIK Digital Agency.\n\n".
                       "*Detail Tagihan:*\n".
                       "• *Layanan:* {$billing->title}\n".
                       "• *Jumlah:* Rp {$formattedAmount} ({$cycle})\n".
                       "• *Jatuh Tempo:* {$dueDateFormatted}\n".
                       "• *Status:* {$statusText}\n\n".
                       "Untuk menghindari gangguan layanan, mohon segera melakukan pembayaran melalui Portal Klien kami di link berikut:\n".
                       "🔗 {$portalUrl}\n\n".
                       "Terima kasih atas kerja sama dan kepercayaan Anda!\n\n".
                       "*DBAIK Digital Agency*\n".
                       '_Silicon Valley Level AI & Technology Partner_';

            $this->line("Sending reminder to {$billing->user->name} ({$recipientNumber})...");

            $result = $this->whatsappService->sendMessage($recipientNumber, $message, $billing);

            if ($result['success']) {
                $sentCount++;
                $this->info("Reminder successfully sent for Billing #{$billing->id} (Status: {$result['status']})");
            } else {
                $this->error("Failed to send reminder for Billing #{$billing->id}");
            }
        }

        $this->info("Billing reminder process finished. Sent: {$sentCount} reminders.");

        return 0;
    }
}
