<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isOnline = fake()->boolean();
        return [
            'organizer_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(4),
            'event_date' => fake()->dateTimeBetween('now', '+2 months'),
            'location' => $isOnline ? null : fake()->address(),
            'is_online' => $isOnline,
            'meeting_link' => $isOnline ? fake()->url() : null,
            'cover_image' => null,
        ];
    }
}
