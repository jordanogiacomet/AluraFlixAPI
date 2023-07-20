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

    $requestWithError = Request::create("/api/criar-categoria", 'POST', [
        'cor' => 'Minha cor'
    ]);

    $responseWithError = $controller->store($requestWithError);

    $this->assertEquals(422, $responseWithError->status());



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

    public function testUpdate()
    {
        // Criação de uma instância do controlador
        $controller = new CategoryController();
    
        // Definição do ID da categoria a ser atualizada
        $id = '2';
    
        // Criação de um objeto de requisição simulada para a rota '/api/atualizar-categoria' com método PUT e dados de exemplo
        $request = Request::create("/api/atualizar-categoria", 'PUT', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);
    
        // Chamada do método update() no controlador com a requisição simulada e o ID da categoria
        $response = $controller->update($request, $id);
    
        // Verificação do status da resposta, esperando que seja 200 (OK)
        $this->assertEquals(200, $response->status());
    
        // Verificação se os dados atualizados estão presentes no banco de dados
        $this->assertDatabaseHas('categories', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);

        $requestWithOneParameter = Request::create('/api/atualizar-categoria', 'PUT', [
            'titulo' => 'Minha categoria'
        ]);
        $responseWithOneParameter = $controller->update($requestWithOneParameter, $id);
        $this->assertEquals(200, $responseWithOneParameter->status());

        $requestWithValidationError = Request::create('/api/atualizar-categoria', 'PUT', [
            'titulo' => 'Minha categoria com mais de 15 caracteres'
        ]);
        $responseWithValidationError = $controller->update($requestWithValidationError, $id);
        $this->assertEquals(422, $responseWithValidationError->status());

        $requestWithError = Request::create('/api/atualizar-categoria', 'PUT', []);
        $responseWithError = $controller->update($requestWithError, $id);
        $this->assertEquals(400, $responseWithError->status());


        $requestWithInvalidCategoryId = Request::create("/api/atualizar-categoria", 'PUT', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);
    
        $responseWithInvalidCategoryId = $controller->update($requestWithInvalidCategoryId, '100000000');
        $this->assertEquals(404, $responseWithInvalidCategoryId->status());

    }

    public function testDestroy()
    {
        // Define o ID da categoria a ser deletada
        $id = '3';
    
        // Faz uma requisição DELETE para a rota '/api/deletar-categoria/{id}' substituindo '{id}' pelo valor do ID definido
        $response = $this->delete("/api/deletar-categoria/{$id}");
    
        // Verifica se o status da resposta é 200 (OK)
        $this->assertEquals(200, $response->status());
    }

    public function testIndexVideosByCategory(){
        $controller = new CategoryController();
        $id = '1';
        $response = $this->get("/api/categories/{$id}/videos");
        $response->assertStatus(200);

        $responseWithError = $this->get("/api/categories/1000000000/videos");
        $responseWithError->assertStatus(404);
    }
}
