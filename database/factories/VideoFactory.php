<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Obtenha um ID aleatório de uma categoria existente
        $categoriaId = Category::inRandomOrder()->first()->id;

        return [
            'categoriaId' => $categoriaId,
            'titulo' => fake()->name(),
            'descricao' => Str::random(10),
            'url' => Str::random(10),
        ];
    }
}
