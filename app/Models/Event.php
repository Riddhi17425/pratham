<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'from_date',
        'to_date',
        'image',
        'image_alt',
        'description',
        'status',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
    ];

    /**
     * Ready-made date text for the website, e.g.
     *   one day          => "Sep 01, 2026"
     *   same year range  => "Sep 01 - Sep 03, 2026"
     *   across two years => "Dec 30, 2026 - Jan 02, 2027"
     *
     * Use in blade: {{ $event->date_range }}
     */
    public function getDateRangeAttribute(): string
    {
        if (! $this->from_date) {
            return '';
        }

        $from = $this->from_date;
        $to   = $this->to_date;

        if (! $to || $from->isSameDay($to)) {
            return $from->format('M d, Y');
        }

        if ($from->year !== $to->year) {
            return $from->format('M d, Y') . ' - ' . $to->format('M d, Y');
        }

        return $from->format('M d') . ' - ' . $to->format('M d, Y');
    }
}