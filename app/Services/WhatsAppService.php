<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\WhatsAppReminder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message and log the transaction.
     *
     * @param  string  $recipient  The WhatsApp number in international format (e.g., 628...)
     * @param  string  $message  The message body to send
     * @param  Billing|null  $billing  The billing record this reminder is associated with (optional)
     */
    public function sendMessage(string $recipient, string $message, ?Billing $billing = null): array
    {
        $gateway = env('WHATSAPP_GATEWAY', 'log'); // 'fonnte', 'twilio', or 'log'
        $fonnteToken = env('FONNTE_TOKEN');
        $status = 'simulated';
        $meta = null;

        // Clean the phone number (remove +, spaces, or leading 0s and convert to 62/international)
        $cleanRecipient = $this->formatPhoneNumber($recipient);

        if ($gateway === 'fonnte' && ! empty($fonnteToken)) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $fonnteToken,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $cleanRecipient,
                    'message' => $message,
                    'countryCode' => '62', // Default fallback country code
                ]);

                $responseData = $response->json();
                $meta = json_encode($responseData);

                if ($response->successful() && ($responseData['status'] ?? false)) {
                    $status = 'sent';
                } else {
                    $status = 'failed';
                    Log::error('Fonnte WhatsApp sending failed: '.json_encode($responseData));
                }
            } catch (\Exception $e) {
                $status = 'failed';
                $meta = $e->getMessage();
                Log::error('WhatsApp send exception: '.$e->getMessage());
            }
        } else {
            // Simulated fallback mode
            Log::info('=== SIMULATED WHATSAPP NOTIFICATION ===');
            Log::info("To: {$cleanRecipient}");
            Log::info("Message: \n{$message}");
            Log::info('========================================');
            $status = 'simulated';
            $meta = 'Logged to Laravel system output successfully (local simulation).';
        }

        // Store log in database for simulated log viewer in client portal
        $reminder = WhatsAppReminder::create([
            'billing_id' => $billing?->id,
            'recipient_number' => $cleanRecipient,
            'message_body' => $message,
            'status' => $status,
            'response_meta' => $meta,
        ]);

        // Update the billing record with the date sent
        if ($billing) {
            $billing->update([
                'last_reminder_sent_at' => now(),
            ]);
        }

        return [
            'success' => in_array($status, ['sent', 'simulated']),
            'status' => $status,
            'reminder' => $reminder,
        ];
    }

    /**
     * Clean and format phone number for WhatsApp.
     */
    private function formatPhoneNumber(string $number): string
    {
        // Remove all non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);

        // Convert leading '0' to '62' (Indonesia country code)
        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        return $number;
    }
}
