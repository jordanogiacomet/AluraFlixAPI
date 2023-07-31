<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para a criação de registros da classe Category.
 */
class CategoryFactory extends Factory
{
    /**
     * Define o estado padrão do modelo (Category).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define as colunas padrão do modelo e seus valores gerados aleatoriamente
        return [
            'titulo' => fake()->name(), // Gera um nome aleatório usando o Faker
            'cor' => Str::random(10), // Gera uma string aleatória com 10 caracteres
        ];
    }


    /**
     * Define o estado para a primeira categoria.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function firstCategory(): Factory
    {
        // Define o estado para a primeira categoria, com título "Livre" e cor "Minha cor"
        return $this->state(function (array $attributes) {
            return [
                'titulo' => 'Livre',
                'cor' => 'Minha cor',
            ];
        });
    }
}