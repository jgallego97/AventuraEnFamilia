<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    public const STATUSES = ['pending', 'confirmed', 'cancelled', 'rejected'];

    protected $fillable = [
        'user_id', 'departure_id', 'spots', 'total_price', 'status',
    ];

    protected function casts(): array
    {
        return [
            'spots' => 'integer',
            'total_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(Departure::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function calculateTotalPrice(): string
    {
        $departure = $this->departure;
        $fullCents = (int) round(((float) $departure->price) * 100);
        $total = 0;

        foreach ($this->participants as $participant) {
            $total += $participant->hasChildDiscount($departure->starts_at)
                ? (int) round($fullCents / 2)
                : $fullCents;
        }

        return number_format($total / 100, 2, '.', '');
    }

    public function refreshTotals(): void
    {
        $this->load('participants', 'departure');

        $this->spots = $this->participants->count();
        $this->total_price = $this->calculateTotalPrice();
        $this->save();
    }

    public function paidTotal(): string
    {
        $paid = (float) $this->payments()->where('status', 'paid')->sum('amount');

        return number_format($paid, 2, '.', '');
    }
}
