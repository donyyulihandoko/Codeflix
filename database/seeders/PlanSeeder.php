<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'title' => 'Basic',
                'slug' => 'basic',
                'price' => 49999,
                'resolution' => '720p',
                'max_devices' => 1,
                'duration' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Standard',
                'price' => 89999,
                'slug' => 'standard',
                'resolution' => '1080p',
                'max_devices' => 2,
                'duration' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Premium',
                'price' => 129999,
                'slug' => 'premium',
                'resolution' => '4k',
                'max_devices' => 4,
                'duration' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Plan::insert($plans);
    }
}
