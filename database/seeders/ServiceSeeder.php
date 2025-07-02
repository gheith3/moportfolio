<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

final class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Creating responsive and dynamic websites using modern technologies like Laravel, Vue.js, and Tailwind CSS.',
                'icon' => 'icon-desktop',
                'sort_order' => 1,
            ],
            [
                'title' => 'Mobile Apps',
                'description' => 'Developing cross-platform mobile applications with React Native and Flutter for iOS and Android.',
                'icon' => 'icon-mobile',
                'sort_order' => 2,
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'Designing intuitive and beautiful user interfaces with focus on user experience and modern design principles.',
                'icon' => 'icon-layers',
                'sort_order' => 3,
            ],
            [
                'title' => 'Database Design',
                'description' => 'Architecting efficient database solutions with optimal performance and scalability in mind.',
                'icon' => 'icon-database',
                'sort_order' => 4,
            ],
            [
                'title' => 'API Development',
                'description' => 'Building robust RESTful APIs and GraphQL endpoints for seamless data integration and communication.',
                'icon' => 'icon-settings',
                'sort_order' => 5,
            ],
            [
                'title' => 'Cloud Solutions',
                'description' => 'Deploying and managing applications on cloud platforms like AWS, Digital Ocean, and Heroku.',
                'icon' => 'icon-cloud-upload',
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
