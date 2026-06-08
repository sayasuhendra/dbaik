<?php

namespace App\Models;

use Database\Factories\MeetingScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingSchedule extends Model
{
    /** @use HasFactory<MeetingScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'topic',
        'meeting_date',
        'meeting_time',
        'status',
        'meeting_link',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'meeting_date' => 'date',
            'meeting_time' => 'datetime:H:i',
        ];
    }
}
