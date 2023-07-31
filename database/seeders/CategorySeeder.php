<?php

namespace Database\Seeders;

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Definindo a classe CategorySeeder que estende a classe Seeder do Laravel
class CategorySeeder extends Seeder
{
    /**
     * Executa o preenchimento inicial da tabela "categories".
     */
    public function run(): void
    {
        // Chama o método "firstCategory" da Factory de Category e cria um registro com os valores definidos nesse método
        Category::factory()->firstCategory()->create();

        // Chama o método "count" da Factory de Category e cria 10 registros com valores aleatórios
        Category::factory()->count(10)->create();
    }
}
