<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reference>
 */
class ReferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Senior Developer',
            'Project Manager',
            'Team Lead',
            'CTO',
            'Lead Designer',
            'Product Manager',
            'Technical Director',
            'CEO',
        ];

        $companies = [
            'Tech Solutions',
            'Digital Agency',
            'Software Corp',
            'Innovation Labs',
            'Creative Studio',
            'Development Hub',
            'IT Services',
            'Code Factory',
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'slogan' => fake()->randomElement($titles) . ' at ' . fake()->randomElement($companies),
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => fake()->boolean(85),
        ];
    }
}
