<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'category',
        'status',
        'priority',
    ];

    /**
     * Get the user who opened this ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages in this ticket.
     */
    public function supportMessages()
    {
        return $this->hasMany(SupportMessage::class);
    }
}
