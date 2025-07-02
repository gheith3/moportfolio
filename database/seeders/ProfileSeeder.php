<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

final class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();

        if ($admin) {
            Profile::updateOrCreate(
                ['user_id' => $admin->id],
                [
                    'title' => 'Full-Stack Developer',
                    'subtitle' => 'Crafting Digital Solutions',
                    'greeting' => 'Hello, I am',
                    'name' => 'John Doe',
                    'bio' => 'I am a passionate full-stack developer with over 5 years of experience in building scalable web applications. I specialize in Laravel, Vue.js, and modern web technologies. I love turning complex problems into simple, beautiful and intuitive solutions.',
                    'image' => '/template/images/hero.jpg',
                    'cv_file' => '/template/docs/cv.pdf',
                    'phone' => '+1 (555) 123-4567',
                    'address' => '123 Tech Street, New York, NY 10001, USA',
                    'social_links' => [
                        [
                            'platform' => 'Facebook',
                            'url' => 'https://facebook.com/johndoe',
                            'icon' => 'fab fa-facebook-f'
                        ],
                        [
                            'platform' => 'Twitter',
                            'url' => 'https://twitter.com/johndoe',
                            'icon' => 'fab fa-twitter'
                        ],
                        [
                            'platform' => 'LinkedIn',
                            'url' => 'https://linkedin.com/in/johndoe',
                            'icon' => 'fab fa-linkedin-in'
                        ],
                        [
                            'platform' => 'GitHub',
                            'url' => 'https://github.com/johndoe',
                            'icon' => 'fab fa-github'
                        ],
                        [
                            'platform' => 'YouTube',
                            'url' => 'https://youtube.com/@johndoe',
                            'icon' => 'fab fa-youtube'
                        ],
                        [
                            'platform' => 'Instagram',
                            'url' => 'https://instagram.com/johndoe',
                            'icon' => 'fab fa-instagram'
                        ]
                    ],
                    'animated_texts' => [
                        'Laravel Developer',
                        'Vue.js Expert',
                        'Full-Stack Engineer',
                        'Problem Solver'
                    ],
                    'background_image' => '/template/images/bg.jpg',
                ]
            );
        }
    }
}
