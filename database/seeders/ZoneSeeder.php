<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['Sierra de Gredos', 'Ávila'],
            ['Picos de Europa', 'Asturias'],
            ['Sierra Nevada', 'Granada'],
            ['Parque Natural del Montseny', 'Barcelona'],
            ['Ordesa y Monte Perdido', 'Huesca'],
            ['Sierra de Guadarrama', 'Madrid'],
        ];

        foreach ($zones as [$name, $province]) {
            Zone::create(['name' => $name, 'province' => $province]);
        }
    }
}
