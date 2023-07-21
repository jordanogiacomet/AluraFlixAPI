<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Video;
use App\Models\Category;

class CategoryModelTest extends TestCase
{
    public function testCreateCategory(){
        $data = [
            'titulo' => 'Categoria de Teste',
            'cor' => '#FF0000'
        ];

        $category = Category::create($data);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertDatabaseHas('categories', $data);


    }

    public function testRetrieveCategory(){
        $category = Category::factory()->create();

        $retrievedCategory = Category::find($category->id);

        $this->assertEquals($category->id, $retrievedCategory->id);

    }

    public function testCategoryVideosRelationship(){
        $category = Category::factory()->create();

        $videos = Video::factory()->count(3)->create([
            'categoriaId' => $category->id
        ]);
    
        $retrievedVideos = $category->videos;
    
        
        $this->assertCount(3, $retrievedVideos);

        foreach($videos as $video){
            $this->assertTrue($retrievedVideos->contains($video));
        }


    }
}
