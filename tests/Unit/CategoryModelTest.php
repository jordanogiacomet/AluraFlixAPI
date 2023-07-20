<?php

namespace Tests\Unit;

use App\Models\Category;
use PHPUnit\Framework\TestCase;

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
}
