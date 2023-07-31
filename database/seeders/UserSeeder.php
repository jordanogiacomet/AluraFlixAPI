<?php

namespace Database\Seeders;

// Importa o modelo de usuário do aplicativo
use App\Models\User;
// Importa a classe Seeder do Laravel
use Illuminate\Database\Seeder;

// Define a classe UserSeeder que estende a classe Seeder do Laravel
class UserSeeder extends Seeder
{
    /**
     * Executa o preenchimento inicial da tabela de usuários.
     */
    public function run(): void
    {
        // Utiliza a factory de usuários para criar 10 registros fictícios na tabela 'users'
        User::factory(10)->create();
    }
}