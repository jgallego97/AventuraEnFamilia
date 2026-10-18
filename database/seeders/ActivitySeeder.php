<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Theme;
use App\Models\Trail;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        // [titulo, descripcion, minutos, edad minima, zona, tematicas, trails[nombre, posicion, tipo, ritmo]]
        $activities = [
            ['Senderismo familiar a la laguna', 'Paseo tranquilo por un sendero sencillo hasta la laguna, pensado para ir con niños.', 180, 4, 'Sierra de Gredos', ['Naturaleza'], [
                ['Sendero de la Laguna', 1, 'main', 'relaxed'],
                ['Circular del Mirador', 2, 'optional', 'moderate'],
            ]],
            ['Travesía de alta montaña', 'Jornada exigente por terreno de alta montaña con el guía, para quienes ya tienen experiencia.', 480, 12, 'Picos de Europa', ['Aventura', 'Naturaleza'], [
                ['Travesía del Pico', 1, 'main', 'intense'],
                ['Camino del Bosque', 2, 'alternative', 'relaxed'],
            ]],
            ['Cascadas y valles', 'Recorrido por valles y cascadas con paradas para disfrutar del paisaje y de la fauna.', 240, 4, 'Ordesa y Monte Perdido', ['Naturaleza'], [
                ['Ruta de las Cascadas', 1, 'main', 'moderate'],
                ['Sendero del Valle', 2, 'optional', 'relaxed'],
            ]],
            ['Ascenso a la cima nevada', 'Ascenso a una cima de alta montaña con desnivel importante y ritmo sostenido.', 420, 12, 'Sierra Nevada', ['Aventura'], [
                ['Ascenso a la Cima', 1, 'main', 'intense'],
            ]],
            ['Miradores al atardecer', 'Ruta corta entre miradores para ver la puesta de sol sin prisas.', 150, 0, 'Sierra Nevada', ['Naturaleza'], [
                ['Ruta de los Miradores', 1, 'main', 'relaxed'],
            ]],
            ['Fuentes y ermitas del Montseny', 'Itinerario cultural y natural entre fuentes y ermitas, apto para toda la familia.', 210, 4, 'Parque Natural del Montseny', ['Cultura', 'Naturaleza'], [
                ['Paseo de las Fuentes', 1, 'main', 'relaxed'],
                ['Circular de las Ermitas', 2, 'main', 'moderate'],
            ]],
            ['Paseo guiado por el arroyo', 'Paseo corto junto al arroyo, ideal para una primera salida con niños pequeños.', 120, 0, 'Sierra de Guadarrama', ['Naturaleza'], [
                ['Sendero del Arroyo', 1, 'main', 'relaxed'],
            ]],
            ['Cuerda Larga: reto de un día', 'Reto de un día completo recorriendo la cuerda, con opción de bajar por un sendero más corto.', 450, 12, 'Sierra de Guadarrama', ['Aventura'], [
                ['Cuerda Larga', 1, 'main', 'intense'],
                ['Sendero del Arroyo', 2, 'alternative', 'relaxed'],
            ]],
        ];

        foreach ($activities as [$title, $description, $minutes, $minAge, $zone, $themes, $trails]) {
            $activity = Activity::create([
                'title' => $title,
                'description' => $description,
                'duration_min' => $minutes,
                'min_age' => $minAge,
                'zone_id' => Zone::where('name', $zone)->firstOrFail()->id,
            ]);

            $activity->themes()->attach(Theme::whereIn('name', $themes)->pluck('id'));

            foreach ($trails as [$trailName, $position, $type, $pace]) {
                $activity->trails()->attach(
                    Trail::where('name', $trailName)->firstOrFail()->id,
                    ['position' => $position, 'type' => $type, 'pace' => $pace],
                );
            }
        }
    }
}
