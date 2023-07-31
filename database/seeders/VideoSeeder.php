<?php

namespace Database\Seeders;

// Importa o modelo de vídeo do aplicativo
use App\Models\Video;
// Importa a classe Seeder do Laravel
use Illuminate\Database\Seeder;

// Define a classe VideoSeeder que estende a classe Seeder do Laravel
class VideoSeeder extends Seeder
{
    /**
     * Executa o preenchimento inicial da tabela de vídeos.
     */
    public function run(): void
    {
        // Utiliza a factory de vídeos para criar 10 registros fictícios na tabela 'videos'
        Video::factory(10)->create();
    }
}