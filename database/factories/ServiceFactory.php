<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $icons = [
            'fas fa-code',
            'fas fa-mobile-alt',
            'fas fa-paint-brush',
            'fas fa-database',
            'fas fa-cogs',
            'fas fa-cloud',
            'fas fa-laptop-code',
            'fas fa-rocket',
            'fas fa-shield-alt',
            'fas fa-chart-line',
        ];

        return [
            'title' => fake()->words(2, true),
            'description' => fake()->sentence(12),
            'icon' => fake()->randomElement($icons),
            'is_active' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
