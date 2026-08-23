<?php

namespace Database\Seeders;

use App\Models\SubscriptionType;
use Illuminate\Database\Seeder;

class SubscriptionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Streaming',
            'Music',
            'Gaming',
            'AI models',
            'Cloud Storage',
            'Software / SaaS',
            'Fitness & Gym',
            'Education',
            'News & Magazines',
            'VPN & Security',
            'Telecom & Internet',
            'Food Delivery',
            'Other',
        ];

        foreach ($types as $type) {
            SubscriptionType::firstOrCreate(['name' => $type]);
        }
    }
}