<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurBrand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'icon',
        'icon_alt',
        'status',
    ];
}
