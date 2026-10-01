<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

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
