<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontendText extends Model
{
    protected $guarded = [];

    protected $casts = [
        'portfolio_detail' => 'array',
        'navbar' => 'array',
        'hero' => 'array',
        'marquee' => 'array',
        'portfolio' => 'array',
        'services' => 'array',
        'showcase' => 'array',
        'testimonials' => 'array',
        'cta' => 'array',
        'gallery' => 'array',
        'other_categories' => 'array',
        'footer' => 'array',
    ];
}
