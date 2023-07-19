<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    public function testIndex()
    {
        // Chamada da rota para a função index
        $response = $this->get("/api/categories");
        // Verificação do status da resposta
        $response->assertStatus(200);
    } 


    public function testStore()
{
    // Criação de uma instância do controlador
    $controller = new CategoryController();

    // Criação de um objeto de requisição simulada para a rota '/api/criar-categoria' com método POST e dados de exemplo
    $request = Request::create("/api/criar-categoria", 'POST', [
        'titulo' => 'Minha categoria',
        'cor' => 'Minha cor'
    ]);

    // Chamada do método store() no controlador com a requisição simulada
    $response = $controller->store($request);

    // Verificação do status da resposta, esperando que seja 200 (OK)
    $this->assertEquals(200, $response->status());

    // Verificação se os dados inseridos na requisição estão presentes no banco de dados
    $this->assertDatabaseHas('categories', [
        'titulo' => 'Minha categoria',
        'cor' => 'Minha cor'
    ]);
}


    public function testShow()
    {
        // Define o ID da categoria a ser exibida
        $id = '1';
    
        // Faz uma requisição GET para a rota '/api/categories/{id}'
        $response = $this->get("/api/categories/{$id}");
    
        // Verifica se o status da resposta é 200 (OK)
        $response->assertStatus(200);
    }

}
