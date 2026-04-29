<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $alumni = User::where('role', 'alumni')->get();
        if ($alumni->isEmpty()) return;

        for ($i = 0; $i < 5; $i++) {
            Event::create([
                'organizer_id' => $alumni->random()->id,
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'location' => fake()->address(),
                'event_date' => fake()->dateTimeBetween('+1 week', '+2 months'),
                'max_seats' => 50,
            ]);
        }
    }
}
