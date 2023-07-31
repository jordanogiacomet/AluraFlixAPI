<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryControllerTest extends TestCase
{
    // Configuração inicial para criar um usuário e fazer login antes dos testes
    protected function setUp(): void
    {
        parent::setUp();
        
        $controller = new UserController();

        // Cria uma requisição simulada para a rota '/api/register' com método POST e dados de exemplo para registro de usuário
        $request = Request::create('/api/register', 'POST', [
            'name' => fake()->name(),
            'email' => fake()->safeEmail,
            'password' => 'senha'
        ]);

        // Chama o método 'register' no controlador para criar o usuário
        $response = $controller->register($request);
    }

    /**
     * Testa a listagem de categorias.
     */
    public function testIndex()
    {
        // Faz uma requisição GET para a rota '/api/categories'
        $response = $this->get("/api/categories");

        // Verifica se o status da resposta é 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Testa a criação de uma categoria com dados válidos.
     */
    public function testStore()
    {
        // Criação de uma instância do controlador
        $controller = new CategoryController();

        // Criação de uma requisição simulada para a rota '/api/criar-categoria' com método POST e dados de exemplo
        $requestFirstCategory = Request::create("/api/criar-categoria", 'POST', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);

        // Chamada do método 'store' no controlador com a requisição simulada
        $responseFirstCategory = $controller->store($requestFirstCategory);

        // Verificação se a resposta tem o status 200 (OK)
        $this->assertEquals(200, $responseFirstCategory->status());

        // Verificação se os dados inseridos na requisição estão presentes no banco de dados
        $this->assertDatabaseHas('categories', [
            'titulo' => 'Livre',
            'cor' => 'Minha cor'
        ]);

        // Criação de outra requisição simulada para a rota '/api/criar-categoria' com método POST e dados de exemplo
        $requestNormalCategory = Request::create("/api/criar-categoria", 'POST', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);

        // Chamada do método 'store' no controlador com a requisição simulada
        $responseNormalCategory = $controller->store($requestNormalCategory);

        // Verificação se a resposta tem o status 200 (OK)
        $this->assertEquals(200, $responseNormalCategory->status());

        // Verificação se os dados inseridos na requisição estão presentes no banco de dados
        $this->assertDatabaseHas('categories', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);   

        // Criação de uma requisição simulada para a rota '/api/criar-categoria' sem o campo obrigatório 'titulo'
        $requestWithError = Request::create("/api/criar-categoria", 'POST', [
            'cor' => 'Minha cor'
        ]);

        // Chamada do método 'store' no controlador com a requisição simulada
        $responseWithError = $controller->store($requestWithError);

        // Verificação se a resposta tem o status 422 (Unprocessable Entity) devido à validação falhar
        $this->assertEquals(422, $responseWithError->status());
    }

    /**
     * Testa a exibição de uma categoria.
     */
    public function testShow()
    {
        // Define o ID da categoria a ser exibida
        $id = '1';
    
        // Faz uma requisição GET para a rota '/api/categories/{id}'
        $response = $this->get("/api/categories/{$id}");
    
        // Verifica se o status da resposta é 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Testa a atualização de uma categoria com dados válidos.
     */
    public function testUpdate()
    {
        // Criação de uma instância do controlador
        $controller = new CategoryController();

        // Definição do ID da categoria a ser atualizada
        $id = '2';

        // Criação de uma requisição simulada para a rota '/api/atualizar-categoria' com método PUT e dados de exemplo
        $request = Request::create("/api/atualizar-categoria", 'PUT', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);

        // Chamada do método 'update' no controlador com a requisição simulada e o ID da categoria
        $response = $controller->update($request, $id);

        // Verificação se a resposta tem o status 200 (OK)
        $this->assertEquals(200, $response->status());

        // Verificação se os dados atualizados estão presentes no banco de dados
        $this->assertDatabaseHas('categories', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);

        // Teste de atualização com apenas um parâmetro
        $requestWithOneParameter = Request::create('/api/atualizar-categoria', 'PUT', [
            'titulo' => 'Minha categoria'
        ]);
        $responseWithOneParameter = $controller->update($requestWithOneParameter, $id);
        $this->assertEquals(200, $responseWithOneParameter->status());

        // Teste de validação de dados (título com mais de 15 caracteres)
        $requestWithValidationError = Request::create('/api/atualizar-categoria', 'PUT', [
            'titulo' => 'Minha categoria com mais de 15 caracteres'
        ]);
        $responseWithValidationError = $controller->update($requestWithValidationError, $id);
        $this->assertEquals(422, $responseWithValidationError->status());

        // Teste de requisição sem parâmetros
        $requestWithError = Request::create('/api/atualizar-categoria', 'PUT', []);
        $responseWithError = $controller->update($requestWithError, $id);
        $this->assertEquals(400, $responseWithError->status());

        // Teste de atualização com ID de categoria inexistente
        $requestWithInvalidCategoryId = Request::create("/api/atualizar-categoria", 'PUT', [
            'titulo' => 'Minha categoria',
            'cor' => 'Minha cor'
        ]);

        // Chamada do método 'update' no controlador com a requisição simulada e um ID de categoria inexistente
        $responseWithInvalidCategoryId = $controller->update($requestWithInvalidCategoryId, '100000000');

        // Verificação se a resposta tem o status 404 (Not Found) para um ID inexistente
        $this->assertEquals(404, $responseWithInvalidCategoryId->status());
    }

    /**
     * Testa a exclusão de uma categoria.
     */
    public function testDestroy()
    {
        // Define o ID da categoria a ser deletada
        $id = '3';
    
        // Faz uma requisição DELETE para a rota '/api/deletar-categoria/{id}' substituindo '{id}' pelo valor do ID definido
        $response = $this->delete("/api/deletar-categoria/{$id}");
    
        // Verifica se o status da resposta é 200 (OK)
        $this->assertEquals(200, $response->status());
    }

    /**
     * Testa a listagem de vídeos por categoria.
     */
    public function testIndexVideosByCategory()
    {
        // Criação de uma instância do controlador
        $controller = new CategoryController();

        // Define o ID da categoria para listar os vídeos
        $id = '1';

        // Faz uma requisição GET para a rota '/api/categories/{id}/videos' substituindo '{id}' pelo valor do ID da categoria
        $response = $this->get("/api/categories/{$id}/videos");

        // Verifica se o status da resposta é 200 (OK)
        $response->assertStatus(200);

        // Faz uma requisição GET para a rota '/api/categories/1000000000/videos', usando um ID inexistente
        $responseWithError = $this->get("/api/categories/1000000000/videos");

        // Verifica se o status da resposta é 404 (Not Found) para um ID inexistente
        $responseWithError->assertStatus(404);
    }
}