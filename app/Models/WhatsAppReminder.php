<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppReminder extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_reminders';

    protected $fillable = [
        'billing_id',
        'recipient_number',
        'message_body',
        'status',
        'response_meta',
    ];

    /**
     * Get the billing that this reminder belongs to.
     */
    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
