<?php

namespace Database\Seeders;

use App\Models\Trail;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class TrailSeeder extends Seeder
{
    public function run(): void
    {
        // [nombre, km, subida m, bajada m, dificultad, zona]
        $trails = [
            ['Sendero de la Laguna', 6.40, 280, 280, 'easy', 'Sierra de Gredos'],
            ['Circular del Mirador', 9.80, 540, 540, 'moderate', 'Sierra de Gredos'],
            ['Travesía del Pico', 14.20, 1100, 1050, 'hard', 'Picos de Europa'],
            ['Camino del Bosque', 4.50, 120, 120, 'easy', 'Picos de Europa'],
            ['Ruta de las Cascadas', 8.30, 410, 410, 'moderate', 'Ordesa y Monte Perdido'],
            ['Sendero del Valle', 5.20, 90, 90, 'easy', 'Ordesa y Monte Perdido'],
            ['Ascenso a la Cima', 12.70, 1250, 1200, 'hard', 'Sierra Nevada'],
            ['Ruta de los Miradores', 7.60, 380, 380, 'moderate', 'Sierra Nevada'],
            ['Paseo de las Fuentes', 3.90, 60, 60, 'easy', 'Parque Natural del Montseny'],
            ['Circular de las Ermitas', 10.40, 620, 620, 'moderate', 'Parque Natural del Montseny'],
            ['Sendero del Arroyo', 5.80, 150, 150, 'easy', 'Sierra de Guadarrama'],
            ['Cuerda Larga', 15.60, 980, 960, 'hard', 'Sierra de Guadarrama'],
        ];

        foreach ($trails as [$name, $distance, $ascent, $descent, $difficulty, $zone]) {
            Trail::create([
                'name' => $name,
                'distance_km' => $distance,
                'ascent_m' => $ascent,
                'descent_m' => $descent,
                'difficulty' => $difficulty,
                'zone_id' => Zone::where('name', $zone)->firstOrFail()->id,
            ]);
        }
    }
}
