<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->name(),
            'cor' => Str::random(10),
        ];
    }


    /**
     * Define the first category's state.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function firstCategory(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'titulo' => 'Livre',
                'cor' => 'Minha cor',
            ];
        });
    }
}
