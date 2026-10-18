<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'first_name', 'last_name', 'birth_date', 'national_id',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function ageAt(CarbonInterface $date): int
    {
        $birth = $this->birth_date;
        $age = $date->year - $birth->year;

        if ($date->month < $birth->month
            || ($date->month === $birth->month && $date->day < $birth->day)) {
            $age--;
        }

        return $age;
    }

    public function requiresNationalId(CarbonInterface $on): bool
    {
        return $this->ageAt($on) >= 14;
    }

    public function hasChildDiscount(CarbonInterface $on): bool
    {
        return $this->ageAt($on) <= 12;
    }
}
