<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departure extends Model
{
    use HasFactory;

    public const STATUSES = ['open', 'in_progress', 'completed', 'cancelled'];

    protected $fillable = [
        'activity_id', 'guide_id', 'starts_at',
        'price', 'capacity', 'status',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'price' => 'decimal:2',
            'capacity' => 'integer',
        ];
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function availableSpots(): int
    {
        $taken = (int) $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('spots');

        return $this->capacity - $taken;
    }
}
