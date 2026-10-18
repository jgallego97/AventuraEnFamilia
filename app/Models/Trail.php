<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trail extends Model
{
    use HasFactory;

    public const DIFFICULTIES = ['easy', 'moderate', 'hard'];

    protected $fillable = [
        'name', 'distance_km', 'ascent_m',
        'descent_m', 'difficulty', 'zone_id',
    ];

    protected function casts(): array
    {
        return [
            'distance_km' => 'decimal:2',
            'ascent_m' => 'integer',
            'descent_m' => 'integer',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class)
            ->withPivot('position', 'type', 'pace');
    }
}
