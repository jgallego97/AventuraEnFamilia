<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->guide()->create([
            'name' => 'Guía de prueba',
            'email' => 'guide@example.com',
        ]);

        Guide::factory()->create([
            'user_id' => $user->id,
            'code' => 'GD-0001',
        ]);

        Guide::factory()->count(3)->create();
    }
}
