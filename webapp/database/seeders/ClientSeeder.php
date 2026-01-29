<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

final class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'TechCorp Solutions',
                'logo' => '/template/images/clients/1.jpg',
                'website' => 'https://techcorp.com',
                'testimonial' => 'Outstanding work! The team delivered exactly what we needed on time and within budget. Highly recommended for any web development project.',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'name' => 'Creative Studios',
                'logo' => '/template/images/clients/2.jpg',
                'website' => 'https://creativestudios.com',
                'testimonial' => 'Professional, creative, and efficient. The final product exceeded our expectations and our clients love the new design.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'name' => 'Digital Innovations',
                'logo' => '/template/images/clients/3.jpg',
                'website' => 'https://digitalinnovations.com',
                'testimonial' => 'Great communication throughout the project. The technical expertise and attention to detail were impressive.',
                'rating' => 4,
                'sort_order' => 3,
            ],
            [
                'name' => 'StartupHub',
                'logo' => '/template/images/clients/1.jpg',
                'website' => 'https://startuphub.com',
                'testimonial' => 'Helped us launch our MVP quickly and efficiently. The scalable architecture has served us well as we\'ve grown.',
                'rating' => 5,
                'sort_order' => 4,
            ],
            [
                'name' => 'Enterprise Systems',
                'logo' => '/template/images/clients/2.jpg',
                'website' => 'https://enterprisesystems.com',
                'testimonial' => 'Reliable partner for complex enterprise projects. Always delivers quality solutions that meet our strict requirements.',
                'rating' => 4,
                'sort_order' => 5,
            ],
            [
                'name' => 'Future Tech',
                'logo' => '/template/images/clients/3.jpg',
                'website' => 'https://futuretech.com',
                'testimonial' => 'Innovative approach and cutting-edge solutions. The team stays up-to-date with the latest technologies.',
                'rating' => 5,
                'sort_order' => 6,
            ],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(
                ['name' => $client['name']],
                $client
            );
        }
    }
}
