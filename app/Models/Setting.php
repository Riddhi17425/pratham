<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'email',
        'linkedin_url',
        'instagram_url',
        'twitter_url',
        'whatsapp_url',
        'facebook_url',
        'status',
    ];
}
