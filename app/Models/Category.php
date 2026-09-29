<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_url',
        'description',
        'meta_title',
        'meta_description',
        'thumbnail',
        'thumbnail_alt',
        'status',
    ];
}
