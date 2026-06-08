<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'billing_cycle',
        'status',
        'due_date',
        'recurring_billing',
        'whatsapp_number',
        'last_reminder_sent_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'recurring_billing' => 'boolean',
        'last_reminder_sent_at' => 'datetime',
    ];

    /**
     * Get the user who owns this billing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the WhatsApp reminders sent for this bill.
     */
    public function whatsappReminders()
    {
        return $this->hasMany(WhatsAppReminder::class);
    }
}
