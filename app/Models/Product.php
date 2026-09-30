<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'name',
        'product_url',
        'image',
        'image_alt',
        'description',
        'catalogue',
        'technical_details',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
