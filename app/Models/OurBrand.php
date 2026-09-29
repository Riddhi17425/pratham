<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'icon_alt',
        'status',
    ];
}