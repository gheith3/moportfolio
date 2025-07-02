<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            ProfileSeeder::class,
            SkillSeeder::class,
            ServiceSeeder::class,
            CategorySeeder::class,
            ProjectSeeder::class,
            ClientSeeder::class,
        ]);

        // Uncomment to create test users
        // User::factory(10)->create();
    }
}
