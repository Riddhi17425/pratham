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
     *   one day          => "Sept 30, 2026"
     *   same year range  => "Nov 18 - Nov 20, 2026"
     *   across two years => "Dec 30, 2026 - Jan 2, 2027"
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

        $formatDay = static function ($date): string {
            $month = $date->format('M');
            return ($month === 'Sep' ? 'Sept' : $month) . ' ' . $date->format('j');
        };
        $formatFull = static fn ($date): string => $formatDay($date) . ', ' . $date->format('Y');

        if (! $to || $from->isSameDay($to)) {
            return $formatFull($from);
        }

        if ($from->year === $to->year) {
            return $formatDay($from) . ' - ' . $formatDay($to) . ', ' . $to->format('Y');
        }

        return $formatFull($from) . ' - ' . $formatFull($to);
    }
}
