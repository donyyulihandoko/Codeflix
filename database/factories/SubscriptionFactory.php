<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Plan;
use App\Models\User;
/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->is_member(),
            'plan_id' => Plan::factory(),
            'active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ];
    }
}
