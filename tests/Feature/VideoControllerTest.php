<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class VideoControllerTest extends TestCase
{   
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Simula o registro de um usuário antes de cada teste
        $controller = new UserController();

        $request = Request::create('/api/register', 'POST', [
            'name' => fake()->name(),
            'email' => fake()->safeEmail,
            'password' => 'senha'
        ]);

        $response = $controller->register($request);  
    }

    /**
     * Testa a listagem de todos os vídeos.
     */
    public function testIndex()
    {
        // Chamada da rota para a função index
        $response = $this->get("/api/videos");

        // Verificação do status da resposta, esperando que seja 200 (OK)
        $response->assertStatus(200);
    } 

    /**
     * Testa a exibição de um vídeo específico.
     */
    public function testShow()
    {
        // Define o ID do vídeo a ser exibido
        $id = '1';

        // Faz uma requisição GET para a rota '/api/videos/{$id}'
        $response = $this->get("/api/videos/{$id}");

        // Verifica se a resposta possui o status HTTP 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Testa a criação de um novo vídeo.
     */
    public function testStore()
    {
        // Criação de uma instância do controlador
        $controller = new VideoController();

        // Criação de um objeto de requisição simulada para a rota '/api/criar-video' com método POST e dados de exemplo
        $request = Request::create("/api/criar-video", 'POST', [
            'categoriaId' => '1',
            'titulo' => 'Meu vídeo',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        // Chamada do método store() no controlador com a requisição simulada
        $response = $controller->store($request);

        // Verificação do status da resposta, esperando que seja 200 (OK)
        $this->assertEquals(200, $response->status());

        // Verificação se os dados inseridos na requisição estão presentes no banco de dados
        $this->assertDatabaseHas('videos', [
            'categoriaId' => '1',
            'titulo' => 'Meu vídeo',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        // Criação de um objeto de requisição simulada para a rota '/api/criar-video' sem o campo obrigatório 'categoriaId'
        $requestWithError = Request::create("/api/criar-video", 'POST', [
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        // Chamada do método store() no controlador com a requisição simulada
        $responseWithError = $controller->store($requestWithError);

        // Verificação se a resposta é de erro de validação (status 422)
        $this->assertEquals(422, $responseWithError->status());
    } 

    /**
     * Testa a exclusão de um vídeo.
     */
    public function testDestroy()
    {
        // Define o ID do vídeo a ser deletado
        $id = '3';

        // Faz uma requisição DELETE para a rota '/api/deletar-video/{$id}'
        $response = $this->delete("/api/deletar-video/{$id}");

        // Verifica se o status da resposta é 200 (OK)
        $this->assertEquals(200, $response->status());
    }

    /**
     * Testa a atualização de um vídeo existente.
     */
    public function testUpdate()
    {
        // Criação de uma instância do controlador
        $controller = new VideoController();

        // Definição do ID do vídeo a ser atualizado
        $id = '1';

        // Criação de um objeto de requisição simulada para a rota '/api/atualizar-video' com método PUT e dados de exemplo
        $request = Request::create("/api/atualizar-video", 'PUT', [
            'categoriaId' => '1',
            'titulo' => 'Meu vídeo',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        // Chamada do método update() no controlador com a requisição simulada e o ID do vídeo
        $response = $controller->update($request, $id);

        // Verificação do status da resposta, esperando que seja 200 (OK)
        $this->assertEquals(200, $response->status());

        // Verificação se os dados atualizados estão presentes no banco de dados
        $this->assertDatabaseHas('videos', [
            'categoriaId' => '1',
            'titulo' => 'Meu vídeo',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        // Criação de um objeto de requisição simulada para a rota '/api/atualizar-video' sem o campo obrigatório 'categoriaId'
        $requestWithError = Request::create("/api/atualizar-video", 'PUT', [
            'categoriaId' => '2',
        ]);

        // Chamada do método update() no controlador com a requisição simulada e o ID do vídeo
        $responseWithError = $controller->update($requestWithError, $id);

        // Verificação se a resposta é de erro de validação (status 400)
        $this->assertEquals(400, $responseWithError->status());

        // Criação de um objeto de requisição simulada para a rota '/api/atualizar-video' com apenas um parâmetro (titulo)
        $requestWithOneParameter = Request::create('/api/atualizar-video', 'PUT', [
            'titulo' => 'Meu video'
        ]);

        // Chamada do método update() no controlador com a requisição simulada e o ID do vídeo
        $responseWithOneParameter = $controller->update($requestWithOneParameter, $id);

        // Verificação se a resposta é de sucesso (status 200)
        $this->assertEquals(200, $responseWithOneParameter->status());

        // Criação de um objeto de requisição simulada para a rota '/api/atualizar-video' sem o campo obrigatório 'categoriaId'
        $requestWithoutCategoryId = Request::create("/api/atualizar-video", 'PUT', [
            'titulo' => 'Meu vídeo',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        // Chamada do método update() no controlador com a requisição simulada e o ID do vídeo
        $responseWithoutCategoryId = $controller->update($requestWithoutCategoryId, $id);

        // Verificação se a resposta é de erro de validação (status 400)
        $this->assertEquals(200, $responseWithoutCategoryId->status());

        // Criação de um objeto de requisição simulada para a rota '/api/atualizar-video' com um ID de vídeo inexistente
        $requestWithInvalidVideoId = Request::create("/api/atualizar-video", 'PUT', [
            'categoriaId' => '1',
            'titulo' => 'Meu vídeo',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        // Chamada do método update() no controlador com a requisição simulada e um ID de vídeo inexistente
        $responseWithInvalidVideoId = $controller->update($requestWithInvalidVideoId, '100000000');

        // Verificação se a resposta é de erro de not found (status 404)
        $this->assertEquals(404, $responseWithInvalidVideoId->status());
    }

    /**
     * Testa a busca de vídeos por termo.
     */
    public function testSearchVideos()
    {
        // Criação de uma instância do controlador
        $controller = new VideoController();

        // Criação de um objeto de requisição simulada para a rota '/api/buscar-videos?search=video' com o termo 'video'
        $request = Request::create('/api/buscar-videos?search=video', 'GET');

        // Chamada do método searchVideos() no controlador com a requisição simulada
        $response = $controller->searchVideos($request);

        // Verificação do status da resposta, esperando que seja 200 (OK)
        $this->assertEquals(200, $response->status());

        // Criação de um objeto de requisição simulada para a rota '/api/buscar-videos?search=categoria' com o termo 'categoria'
        $requestNotFound = Request::create('/api/buscar-videos?search=categoria', 'GET');

        // Chamada do método searchVideos() no controlador com a requisição simulada
        $responseNotFound = $controller->searchVideos($requestNotFound);

        // Verificação do status da resposta, esperando que seja 404 (Not Found) devido à busca não encontrar vídeos com o termo 'categoria'
        $this->assertEquals(404, $responseNotFound->status());
    }
}
    