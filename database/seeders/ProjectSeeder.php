<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Database\Seeder;

final class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'E-commerce Platform',
                'slug' => 'e-commerce-platform',
                'description' => 'A comprehensive e-commerce solution built with Laravel and Vue.js, featuring payment integration, inventory management, and admin dashboard.',
                'image' => '/template/images/portfolio/1.jpg',
                'gallery_images' => [
                    '/template/images/portfolio/1.jpg',
                    '/template/images/portfolio/2.jpg',
                ],
                'project_url' => 'https://ecommerce-demo.com',
                'github_url' => 'https://github.com/johndoe/ecommerce-platform',
                'client' => 'TechStore Inc.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe', 'Tailwind CSS'],
                'completion_date' => '2024-03-15',
                'is_featured' => true,
                'sort_order' => 1,
                'categories' => ['web-development', 'e-commerce'],
            ],
            [
                'title' => 'Task Management App',
                'slug' => 'task-management-app',
                'description' => 'A collaborative task management application with real-time updates, team collaboration features, and project tracking.',
                'image' => '/template/images/portfolio/2.jpg',
                'gallery_images' => [
                    '/template/images/portfolio/2.jpg',
                    '/template/images/portfolio/3.jpg',
                ],
                'project_url' => 'https://taskapp-demo.com',
                'github_url' => 'https://github.com/johndoe/task-management',
                'client' => 'ProductiveCorp',
                'technologies' => ['Laravel', 'Livewire', 'Alpine.js', 'WebSockets'],
                'completion_date' => '2024-02-20',
                'is_featured' => true,
                'sort_order' => 2,
                'categories' => ['web-development'],
            ],
            [
                'title' => 'Restaurant Mobile App',
                'slug' => 'restaurant-mobile-app',
                'description' => 'A mobile application for restaurant ordering with menu browsing, cart management, and order tracking functionality.',
                'image' => '/template/images/portfolio/3.jpg',
                'gallery_images' => [
                    '/template/images/portfolio/3.jpg',
                    '/template/images/portfolio/4.jpg',
                ],
                'project_url' => 'https://restaurant-app.com',
                'github_url' => 'https://github.com/johndoe/restaurant-app',
                'client' => 'Delicious Bites',
                'technologies' => ['React Native', 'Laravel API', 'Firebase', 'Stripe'],
                'completion_date' => '2024-01-10',
                'is_featured' => false,
                'sort_order' => 3,
                'categories' => ['mobile-apps'],
            ],
            [
                'title' => 'Corporate Website Redesign',
                'slug' => 'corporate-website-redesign',
                'description' => 'Complete redesign of a corporate website with modern UI/UX, improved performance, and SEO optimization.',
                'image' => '/template/images/portfolio/4.jpg',
                'gallery_images' => [
                    '/template/images/portfolio/4.jpg',
                    '/template/images/portfolio/5.jpg',
                ],
                'project_url' => 'https://corporate-site.com',
                'github_url' => null,
                'client' => 'Business Solutions Ltd.',
                'technologies' => ['Figma', 'Laravel', 'Tailwind CSS', 'Alpine.js'],
                'completion_date' => '2023-12-05',
                'is_featured' => false,
                'sort_order' => 4,
                'categories' => ['web-development', 'ui-ux-design'],
            ],
            [
                'title' => 'Learning Management System',
                'slug' => 'learning-management-system',
                'description' => 'An online learning platform with course management, video streaming, quizzes, and progress tracking.',
                'image' => '/template/images/portfolio/5.jpg',
                'gallery_images' => [
                    '/template/images/portfolio/5.jpg',
                    '/template/images/portfolio/6.jpg',
                ],
                'project_url' => 'https://lms-demo.com',
                'github_url' => 'https://github.com/johndoe/lms',
                'client' => 'EduTech Academy',
                'technologies' => ['Laravel', 'Vue.js', 'FFmpeg', 'Amazon S3'],
                'completion_date' => '2023-11-20',
                'is_featured' => true,
                'sort_order' => 5,
                'categories' => ['web-development'],
            ],
            [
                'title' => 'Portfolio Website',
                'slug' => 'portfolio-website',
                'description' => 'A clean and modern portfolio website showcasing creative work with smooth animations and responsive design.',
                'image' => '/template/images/portfolio/6.jpg',
                'gallery_images' => [
                    '/template/images/portfolio/6.jpg',
                    '/template/images/portfolio/1.jpg',
                ],
                'project_url' => 'https://creative-portfolio.com',
                'github_url' => 'https://github.com/johndoe/portfolio',
                'client' => 'Creative Artist',
                'technologies' => ['Laravel', 'Tailwind CSS', 'GSAP', 'Intersection Observer'],
                'completion_date' => '2023-10-15',
                'is_featured' => false,
                'sort_order' => 6,
                'categories' => ['web-development', 'ui-ux-design'],
            ],
        ];

        foreach ($projects as $projectData) {
            $categories = $projectData['categories'];
            unset($projectData['categories']);

            $project = Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );

            // Attach categories
            $categoryIds = Category::whereIn('slug', $categories)->pluck('id');
            $project->categories()->sync($categoryIds);
        }
    }
}
