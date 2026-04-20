<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 
        'category', 
        'location', 
        'year', 
        'type', 
        'description', 
        'photos', 
        'is_featured'
    ];

    protected $casts = [
        'description' => 'array',
        'photos' => 'array',
        'is_featured' => 'boolean',
    ];
}
