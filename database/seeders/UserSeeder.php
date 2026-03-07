<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "Active Now",
            "email" => "active@email.com",
            "last_login_at" => now()->subDays(2),
        ]);

        User::factory()->create([
            "name" => "Inactive User",
            "email" => "inactive@example.com",
            "last_login_at" => now()->subDays(10),
        ]);

        User::factory()->create([
            "name" => 'Mahek',
            "email" => "minactive@example.com",
            "last_login_at" => now()->subDays(7),
        ]);

        User::factory()->create([
            "name" => 'Chesta',
            "email" => "cinactive@example.com",
            "last_login_at" => now()->subDays(8),
        ]);

        User::factory()->create([
            "name" => 'Nafis',
            "email" => "ninactive@example.com",
            "last_login_at" => now()->subDays(6),
        ]);
    }
}
