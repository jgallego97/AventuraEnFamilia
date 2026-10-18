<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $staff = [
            ['Administrador', 'admin@example.com', 'admin'],
            ['Coordinadora', 'coordinator@example.com', 'coordinator'],
            ['Responsable de grupo', 'group-leader@example.com', 'group_leader'],
            ['Atención al cliente', 'support@example.com', 'customer_support'],
        ];

        foreach ($staff as [$name, $email, $role]) {
            User::factory()->withRole($role)->create([
                'name' => $name,
                'email' => $email,
            ]);
        }

        User::factory()->count(20)->create();
    }
}
