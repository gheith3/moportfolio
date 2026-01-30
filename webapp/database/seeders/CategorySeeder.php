<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::query()->exists()) {
            return;
        }
        $categories = [
            // Portfolio Categories
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Full-stack web applications and websites',
                'type' => 'portfolio',
                'sort_order' => 1,
            ],
            [
                'name' => 'Mobile Apps',
                'slug' => 'mobile-apps',
                'description' => 'iOS and Android mobile applications',
                'type' => 'portfolio',
                'sort_order' => 2,
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'User interface and experience design projects',
                'type' => 'portfolio',
                'sort_order' => 3,
            ],
            [
                'name' => 'E-commerce',
                'slug' => 'e-commerce',
                'description' => 'Online shopping and e-commerce solutions',
                'type' => 'portfolio',
                'sort_order' => 4,
            ],
            // Blog Categories
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest tech trends and programming insights',
                'type' => 'blog',
                'sort_order' => 1,
            ],
            [
                'name' => 'Tutorials',
                'slug' => 'tutorials',
                'description' => 'Step-by-step guides and how-to articles',
                'type' => 'blog',
                'sort_order' => 2,
            ],
            [
                'name' => 'Industry News',
                'slug' => 'industry-news',
                'description' => 'Web development and tech industry updates',
                'type' => 'blog',
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
