<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareDemo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'demo_url',
        'mockup_code',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
