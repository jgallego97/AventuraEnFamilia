<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Fecha que actúa como hoy: las salidas completadas quedan antes y las abiertas después.
    public const REFERENCE_DATE = '2026-10-20';

    public function run(): void
    {
        fake()->seed(2026);
        fake()->unique(true);

        $this->call([
            ZoneSeeder::class,
            ThemeSeeder::class,
            UserSeeder::class,
            GuideSeeder::class,
            TrailSeeder::class,
            ActivitySeeder::class,
            DepartureSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
