<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function testIndex()
    {
        // Chamada da rota para a função index
        $response = $this->get("/api/categories");
        // Verificação do status da resposta
        $response->assertStatus(200);
    } 
}
