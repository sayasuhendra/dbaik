<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'message',
        'is_admin',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * Get the support ticket for this message.
     */
    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    /**
     * Get the user who sent this message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
