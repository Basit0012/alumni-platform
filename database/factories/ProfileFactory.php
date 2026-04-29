<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'avatar' => null,
            'headline' => fake()->sentence(6),
            'company' => fake()->company(),
            'job_title' => fake()->jobTitle(),
            'graduation_year' => fake()->numberBetween(2010, 2024),
            'major' => fake()->randomElement(['Computer Science', 'Information Technology', 'Software Engineering', 'Business Administration']),
            'bio' => fake()->paragraph(),
            'linkedin_url' => 'https://linkedin.com/in/' . fake()->userName(),
            'github_url' => 'https://github.com/' . fake()->userName(),
        ];
    }
}
