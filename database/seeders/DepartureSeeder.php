<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Departure;
use App\Models\Guide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DepartureSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::parse(DatabaseSeeder::REFERENCE_DATE)->startOfDay();
        $guides = Guide::orderBy('id')->get();
        $n = 0;

        foreach (Activity::orderBy('id')->get() as $i => $activity) {
            foreach ([0, 1, 2, 3] as $k) {
                $hour = 9 + ($i % 2);

                $startsAt = $k < 2
                    ? $today->copy()->subDays(10 + $n)->setTime($hour, 0)
                    : $today->copy()->addDays(5 + $n)->setTime($hour, 0);
                $status = $k < 2 ? 'completed' : 'open';

                if ($i === 0 && $k === 1) {
                    // La única salida en curso: hoy mismo.
                    $startsAt = $today->copy()->setTime(9, 0);
                    $status = 'in_progress';
                } elseif ($k === 3 && $i % 2 === 1) {
                    $status = 'cancelled';
                }

                $guide = ($status === 'open' && $n % 4 === 0)
                    ? null
                    : $guides[$n % $guides->count()];

                Departure::create([
                    'activity_id' => $activity->id,
                    'guide_id' => $guide?->id,
                    'starts_at' => $startsAt,
                    'price' => fake()->randomFloat(2, 10, 60),
                    'capacity' => fake()->numberBetween(8, 25),
                    'status' => $status,
                ]);

                $n++;
            }
        }
    }
}
