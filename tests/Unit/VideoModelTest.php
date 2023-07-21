<?php

namespace Tests\Unit;

use App\Models\Video;
use App\Models\Category;
use Tests\TestCase;

class VideoModelTest extends TestCase
{

    public function testCreateVideo(){
        
        $category = Category::factory()->create();
        
        $data = [
            'categoriaId' => $category->id,
            'titulo' => 'Video de teste',
            'descricao' => 'Descricao de teste',
            'url' => 'https://www.youtube.com/watch?v=bgqGdIoa52s'
        ];
    
        $video = Video::create($data);

        $this->assertInstanceOf(Video::class, $video);
        $this->assertDatabaseHas('videos', $data);
    
    }


    public function testRetrievedVideo(){
        $video = Video::factory()->create();

        $retrievedVideo = Video::find($video->id);

        $this->assertEquals($video->id, $retrievedVideo->id);
    }

}
