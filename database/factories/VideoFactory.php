<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para a criação de registros da classe Video.
 */
class VideoFactory extends Factory
{
    /**
     * Define o estado padrão do modelo (Video).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtenha um ID aleatório de uma categoria existente
        $categoriaId = Category::inRandomOrder()->first()->id;

        // Define as colunas padrão do modelo e seus valores gerados aleatoriamente
        return [
            'categoriaId' => $categoriaId, // ID aleatório de uma categoria existente
            'titulo' => fake()->name(), // Gera um nome aleatório usando o Faker
            'descricao' => Str::random(10), // Gera uma string aleatória com 10 caracteres
            'url' => Str::random(10), // Gera uma string aleatória com 10 caracteres
        ];
    }
}