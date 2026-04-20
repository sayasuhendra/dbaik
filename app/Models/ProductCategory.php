<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'slug', 'thumbnail'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
