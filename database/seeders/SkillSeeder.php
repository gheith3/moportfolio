<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Profile;
use Illuminate\Database\Seeder;

final class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = Profile::first();

        if ($profile) {
            $skills = [
                ['name' => 'Laravel', 'percentage' => 95, 'sort_order' => 1],
                ['name' => 'PHP', 'percentage' => 90, 'sort_order' => 2],
                ['name' => 'Vue.js', 'percentage' => 85, 'sort_order' => 3],
                ['name' => 'JavaScript', 'percentage' => 88, 'sort_order' => 4],
                ['name' => 'MySQL', 'percentage' => 80, 'sort_order' => 5],
                ['name' => 'Tailwind CSS', 'percentage' => 92, 'sort_order' => 6],
            ];

            foreach ($skills as $skill) {
                Skill::updateOrCreate(
                    [
                        'profile_id' => $profile->id,
                        'name' => $skill['name']
                    ],
                    $skill
                );
            }
        }
    }
}
