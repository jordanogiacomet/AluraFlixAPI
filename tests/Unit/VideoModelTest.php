<?php

namespace Tests\Unit;

use App\Models\Video;
use App\Models\Category;
use Tests\TestCase;

class VideoModelTest extends TestCase
{
    /**
     * Testa a criação de um vídeo.
     */
    public function testCreateVideo()
    {
        // Criação de uma categoria de exemplo utilizando o Factory
        $category = Category::factory()->create();
        
        // Dados de exemplo para criar um vídeo
        $data = [
            'categoriaId' => $category->id,
            'titulo' => 'Video de teste',
            'descricao' => 'Descricao de teste',
            'url' => 'https://www.youtube.com/watch?v=bgqGdIoa52s'
        ];
    
        // Criação do vídeo utilizando o modelo Video
        $video = Video::create($data);

        // Verificação se o vídeo foi criado corretamente e é uma instância de Video
        $this->assertInstanceOf(Video::class, $video);

        // Verificação se o vídeo foi adicionado corretamente ao banco de dados
        $this->assertDatabaseHas('videos', $data);
    }


    /**
     * Testa a recuperação de um vídeo por ID.
     */
    public function testRetrievedVideo()
    {
        // Criação de um vídeo de exemplo utilizando o Factory
        $video = Video::factory()->create();

        // Recuperação do vídeo utilizando o método find() do modelo Video
        $retrievedVideo = Video::find($video->id);

        // Verificação se o vídeo foi corretamente recuperado por ID
        $this->assertEquals($video->id, $retrievedVideo->id);
    }
}
