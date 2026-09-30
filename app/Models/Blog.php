<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'url',
        'front_image',
        'front_image_alt',
        'detail_image',
        'detail_image_alt',
        'cta_image',
        'cta_image_alt',
        'cta_link_url',
        'date',
        'meta_title',
        'meta_description',
        'short_description',
        'detail_description',
        'conclusion',
        'schema_json',
        'faqs',
        'status',
    ];

    /**
     * `faqs` is stored as a JSON array of {faq_title, faq_description} objects.
     * Casting it to array means $blog->faqs is already a PHP array when read,
     * and assigning a PHP array to it is automatically encoded to JSON on save.
     */
    protected $casts = [
        'date' => 'date',
        'faqs' => 'array',
    ];
}
