<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserControllerTest extends TestCase
{
    /**
     * Testa o registro de um novo usuário.
     */
    public function testRegister()
    {       
        // Criação de uma instância do controlador UserController
        $controller = new UserController();

        // Criação de um objeto de requisição simulada para a rota '/api/register' com método POST e dados de exemplo
        $request = Request::create('/api/register', 'POST', [
            'name' => 'test-user',
            'email' => 'test@test',
            'password' => 'test'
        ]);

        // Chamada do método register() no controlador com a requisição simulada
        $response = $controller->register($request);

        // Verificação do status da resposta, esperando que seja 200 (OK)
        $this->assertEquals(200, $response->status());
    }

    /**
     * Testa o processo de login de um usuário.
     */
    public function testLogin()
    {      
        // Faz uma requisição POST para a rota '/api/login' com dados de exemplo
        $response = $this->post('/api/login', [
            'name' => 'test-user',
            'password' => 'test',
        ]);

        // Verifica se o status da resposta é 200 (OK) para um login bem-sucedido
        $response->assertStatus(200);

        // Faz uma requisição POST para a rota '/api/login' sem o campo obrigatório 'password'
        $responseWithValidationError = $this->post('/api/login', [
            'name' => 'test-user'
        ]);

        // Verifica se o status da resposta é 422 (Unprocessable Entity) devido à validação falhar
        $responseWithValidationError->assertStatus(422);

        // Faz uma requisição POST para a rota '/api/login' com credenciais inválidas
        $responseWithWrongCredentials = $this->post('/api/login', [
            'name' => 'error-test',
            'password' => 'error'
        ]);

        // Verifica se o status da resposta é 404 (Not Found) para credenciais inválidas
        $responseWithWrongCredentials->assertStatus(404);
    }

    /**
     * Testa o processo de logout de um usuário autenticado.
     */
    public function testLogout()
    {
        // Faz uma requisição POST para a rota '/api/logout'
        $response = $this->post('/api/logout');

        // Verifica se o status da resposta é 200 (OK)
        $response->assertStatus(200);
    }
}

