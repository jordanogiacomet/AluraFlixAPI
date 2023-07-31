<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Video;
use App\Models\Category;

class CategoryModelTest extends TestCase
{
    /**
     * Testa a criação de uma categoria.
     */
    public function testCreateCategory()
    {
        // Dados de exemplo para criar uma categoria
        $data = [
            'titulo' => 'Categoria de Teste',
            'cor' => '#FF0000'
        ];

        // Criação da categoria utilizando o modelo Category
        $category = Category::create($data);

        // Verificação se a categoria foi criada corretamente e é uma instância de Category
        $this->assertInstanceOf(Category::class, $category);

        // Verificação se a categoria foi adicionada corretamente ao banco de dados
        $this->assertDatabaseHas('categories', $data);
    }

    /**
     * Testa a recuperação de uma categoria por ID.
     */
    public function testRetrieveCategory()
    {
        // Criação de uma categoria de exemplo utilizando o Factory
        $category = Category::factory()->create();

        // Recuperação da categoria utilizando o método find() do modelo Category
        $retrievedCategory = Category::find($category->id);

        // Verificação se a categoria foi corretamente recuperada por ID
        $this->assertEquals($category->id, $retrievedCategory->id);
    }

    /**
     * Testa o relacionamento entre categorias e vídeos.
     */
    public function testCategoryVideosRelationship()
    {
        // Criação de uma categoria de exemplo utilizando o Factory
        $category = Category::factory()->create();

        // Criação de 3 vídeos de exemplo relacionados à categoria criada acima
        $videos = Video::factory()->count(3)->create([
            'categoriaId' => $category->id
        ]);

        // Recuperação dos vídeos relacionados à categoria através do relacionamento definido no modelo Category
        $retrievedVideos = $category->videos;

        // Verificação se os vídeos foram corretamente relacionados à categoria
        $this->assertCount(3, $retrievedVideos);

        // Verificação se cada vídeo criado está presente na coleção de vídeos relacionados à categoria
        foreach ($videos as $video) {
            $this->assertTrue($retrievedVideos->contains($video));
        }
    }
}
