<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

final class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Popular Font Awesome icons for services:
     * - Development: fas fa-code, fas fa-laptop-code, fab fa-github
     * - Mobile: fas fa-mobile-alt, fas fa-tablet-alt
     * - Design: fas fa-paint-brush, fas fa-palette, fas fa-magic
     * - Database: fas fa-database, fas fa-server
     * - API/Settings: fas fa-cogs, fas fa-wrench, fas fa-tools
     * - Cloud: fas fa-cloud, fas fa-cloud-upload-alt
     * - Security: fas fa-shield-alt, fas fa-lock
     * - Analytics: fas fa-chart-line, fas fa-chart-bar
     * - SEO: fas fa-search, fas fa-rocket
     * - Support: fas fa-headset, fas fa-life-ring
     */
    public function run(): void
    {
        if (Service::query()->exists()) {
            return;
        }

        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Creating responsive and dynamic websites using modern technologies like Laravel, Vue.js, and Tailwind CSS.',
                'icon' => 'fas fa-code',
                'sort_order' => 1,
            ],
            [
                'title' => 'Mobile Apps',
                'description' => 'Developing cross-platform mobile applications with React Native and Flutter for iOS and Android.',
                'icon' => 'fas fa-mobile-alt',
                'sort_order' => 2,
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'Designing intuitive and beautiful user interfaces with focus on user experience and modern design principles.',
                'icon' => 'fas fa-paint-brush',
                'sort_order' => 3,
            ],
            [
                'title' => 'Database Design',
                'description' => 'Architecting efficient database solutions with optimal performance and scalability in mind.',
                'icon' => 'fas fa-database',
                'sort_order' => 4,
            ],
            [
                'title' => 'API Development',
                'description' => 'Building robust RESTful APIs and GraphQL endpoints for seamless data integration and communication.',
                'icon' => 'fas fa-cogs',
                'sort_order' => 5,
            ],
            [
                'title' => 'Cloud Solutions',
                'description' => 'Deploying and managing applications on cloud platforms like AWS, Digital Ocean, and Heroku.',
                'icon' => 'fas fa-cloud',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                $service
            );
        }
    }
}
