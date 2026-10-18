<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Naturaleza', 'Cultura', 'Aventura'] as $name) {
            Theme::create(['name' => $name]);
        }
    }
}
