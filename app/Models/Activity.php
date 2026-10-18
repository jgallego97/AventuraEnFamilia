<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class Activity extends Model
{
    use HasFactory;

    public const TRAIL_TYPES = ['main', 'optional', 'alternative'];
    public const PACES = ['relaxed', 'moderate', 'intense'];

    protected $fillable = [
        'title', 'description', 'duration_min',
        'min_age', 'active', 'zone_id',
    ];

    protected function casts(): array
    {
        return [
            'duration_min' => 'integer',
            'min_age' => 'integer',
            'active' => 'boolean',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function departures(): HasMany
    {
        return $this->hasMany(Departure::class);
    }

    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class);
    }

    public function trails(): BelongsToMany
    {
        return $this->belongsToMany(Trail::class)
            ->withPivot('position', 'type', 'pace')
            ->orderByPivot('position');
    }

    public function mainTrails(): BelongsToMany
    {
        return $this->trails()->wherePivot('type', 'main');
    }

    public function addTrail(
        Trail $trail,
        int $position,
        string $type = 'main',
        string $pace = 'moderate',
    ): void {
        $this->trails()->attach($trail->id, [
            'position' => $position,
            'type' => $type,
            'pace' => $pace,
        ]);
    }

    /**
     * Deja la actividad con exactamente estos trails.
     * Cada elemento: ['trail_id' => 1, 'position' => 1, 'type' => 'main', 'pace' => 'moderate'].
     */
    public function syncTrails(array $trails): void
    {
        $data = [];

        foreach ($trails as $trail) {
            $data[$trail['trail_id']] = [
                'position' => $trail['position'],
                'type' => $trail['type'] ?? 'main',
                'pace' => $trail['pace'] ?? 'moderate',
            ];
        }

        $this->trails()->sync($data);
    }

    /**
     * Reordena los trails de la actividad. Recibe los ids en el orden nuevo
     * y tiene que incluir todos los trails de la actividad.
     */
    public function reorderTrails(array $trailIds): void
    {
        $given = collect($trailIds)->map(fn ($id) => (int) $id)->sort()->values()->all();
        $current = $this->trails()->pluck('trails.id')->map(fn ($id) => (int) $id)->sort()->values()->all();

        if ($given !== $current) {
            throw new InvalidArgumentException('La lista debe contener exactamente los trails de la actividad.');
        }

        DB::transaction(function () use ($trailIds) {
            // Posiciones provisionales, para no chocar con el UNIQUE
            // (actividad, posición) mientras se intercambian.
            foreach (array_values($trailIds) as $index => $trailId) {
                $this->trails()->updateExistingPivot($trailId, ['position' => 100 + $index + 1]);
            }

            foreach (array_values($trailIds) as $index => $trailId) {
                $this->trails()->updateExistingPivot($trailId, ['position' => $index + 1]);
            }
        });
    }
}
