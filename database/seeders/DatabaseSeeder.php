<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Responsável',
            'email' => 'responsavel@safe.local',
            'role' => 'responsavel',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Professor',
            'email' => 'professor@safe.local',
            'role' => 'professor',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Portaria',
            'email' => 'portaria@safe.local',
            'role' => 'portaria',
            'password' => bcrypt('password'),
        ]);
    }
}
