<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para a criação de registros da classe User.
 */
class UserFactory extends Factory
{
    /**
     * Define o estado padrão do modelo (User).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define as colunas padrão do modelo e seus valores gerados aleatoriamente
        return [
            'name' =>  fake()->name(), // Gera um nome aleatório usando o Faker
            'email' => fake()->safeEmail, // Gera um email aleatório usando o Faker
            'password' => bcrypt('senha') // Define a senha como 'senha' criptografada usando bcrypt
        ];
    }
}