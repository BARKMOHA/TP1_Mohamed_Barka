<?php

namespace Database\Factories;
use App\Models\Film;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Critic>
 */
class CriticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(1, 10),
            'comment' => $this->faker->paragraph(),

            // https://www.slingacademy.com/article/laravel-using-faker-to-seed-sample-data-for-testing-and-practice/
            'user_id' => \App\Models\User::factory(),
            'film_id' => Film::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
        
    }
}
