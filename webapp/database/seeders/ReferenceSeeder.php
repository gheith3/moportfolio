<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Reference;
use Illuminate\Database\Seeder;

final class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Reference::query()->exists()) {
            return;
        }

        $references = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@techcorp.com',
                'phone' => '+1 (555) 123-4567',
                'slogan' => 'Senior Developer at TechCorp Solutions',
                'sort_order' => 1,
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@digitalagency.com',
                'phone' => '+1 (555) 234-5678',
                'slogan' => 'Project Manager at Digital Agency Pro',
                'sort_order' => 2,
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.rodriguez@innovatetech.com',
                'phone' => '+1 (555) 345-6789',
                'slogan' => 'CTO at InnovateTech Labs',
                'sort_order' => 3,
            ],
            [
                'name' => 'David Thompson',
                'email' => 'david.thompson@creativestudio.com',
                'phone' => '+1 (555) 456-7890',
                'slogan' => 'Lead Designer at Creative Studio Inc',
                'sort_order' => 4,
            ],
            [
                'name' => 'Lisa Wang',
                'email' => 'lisa.wang@softwaredevelopment.com',
                'phone' => '+1 (555) 567-8901',
                'slogan' => 'Technical Director at Software Development Hub',
                'sort_order' => 5,
            ],
            [
                'name' => 'Robert Martinez',
                'email' => 'robert.martinez@techsolutions.com',
                'phone' => '+1 (555) 678-9012',
                'slogan' => 'CEO at Tech Solutions Group',
                'sort_order' => 6,
            ],
        ];

        foreach ($references as $reference) {
            Reference::updateOrCreate(
                ['email' => $reference['email']],
                $reference
            );
        }
    }
}
