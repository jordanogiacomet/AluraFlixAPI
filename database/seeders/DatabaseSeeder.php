<?php

namespace Database\Seeders;

// Importa a classe Seeder do Laravel
use Illuminate\Database\Seeder;
// Importa os seeders que serão executados
use Database\Seeders\CategorySeeder;
use Database\Seeders\VideoSeeder;
use Database\Seeders\UserSeeder;

// Define a classe DatabaseSeeder que estende a classe Seeder do Laravel
class DatabaseSeeder extends Seeder
{
    /**
     * Executa o preenchimento inicial do banco de dados.
     */
    public function run(): void
    {
        // Chama os seeders correspondentes para popular o banco de dados com dados fictícios
        $this->call(CategorySeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(UserSeeder::class);

        // Opcionalmente, poderiam ser utilizadas as factories para criar registros aleatórios
        // \App\Models\User::factory(10)->create();

        // Ou criar um usuário específico para testes
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}