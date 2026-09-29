<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalDataSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brochure',
        'pdf',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
