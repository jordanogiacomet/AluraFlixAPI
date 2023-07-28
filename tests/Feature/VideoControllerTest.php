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
        
        $controller = new UserController();

        $request = Request::create('/api/register', 'POST', [
            'name' => fake()->name(),
            'email' => fake()->safeEmail,
            'password' => 'senha'
        ]);

        $response = $controller->register($request);  
    }

    public function testIndex()
    {
        // Chamada da rota para a função index
        $response = $this->get("/api/videos");
        // Verificação do status da resposta
        $response->assertStatus(200);
    } 

    public function testShow(){
        $id = '1';
        // Faz uma requisição GET para a rota '/api/videos/{$id}'
        $response = $this->get("/api/videos/{$id}");
        // Verifica se a resposta possui o status HTTP 200 (OK)
        $response->assertStatus(200);
    }

    public function testStore(){
        $controller = new VideoController();
    
        // Criação de um objeto de requisição simulada para a rota '/api/criar' com método POST e dados de exemplo
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

        $requestWithError = Request::create("/api/criar-video", 'POST', [
            'categoriaId' => '35',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);

        $responseWithError = $controller->store($requestWithError);

         // Verificação se a resposta é de erro de validação (status 422)
        $this->assertEquals(422, $responseWithError->status());


    } 
    
    public function testDestroy()
{
    // Define o ID do vídeo a ser deletado
    $id = '3';

    // Faz uma requisição GET para a rota '/api/deletar/{$id}'
    $response = $this->delete("/api/deletar-video/{$id}");

    // Verifica se o status da resposta é 200 (OK)
    $this->assertEquals(200, $response->status());
}


public function testUpdate()
{
    // Criação de uma instância do controlador
    $controller = new VideoController();

    // Definição do ID do vídeo a ser atualizado
    $id = '1';

    // Criação de um objeto de requisição simulada para a rota '/api/criar' com método POST e dados de exemplo
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

    $requestWithError = Request::create("/api/atualizar-video", 'PUT', [
        'categoriaId' => '2',
    ]);
    $responseWithError = $controller->update($requestWithError, $id);
     // Verificação se a resposta é de erro de validação (status 400)
    $this->assertEquals(400, $responseWithError->status());


    $requestWithOneParameter = Request::create('/api/atualizar-video', 'PUT', [
        'titulo' => 'Meu video'
    ]);
    $responseWithOneParameter = $controller->update($requestWithOneParameter, $id);
    $this->assertEquals(200, $responseWithOneParameter->status());

    $requestWithoutCategoryId = Request::create("/api/atualizar-video", 'PUT', [
        'titulo' => 'Meu vídeo',
        'descricao' => 'Descrição do vídeo',
        'url' => 'https://www.example.com/video'
    ]);
    $responseWithoutCategoryId = $controller->update($requestWithoutCategoryId, $id);
     // Verificação se a resposta é de erro de validação (status 400)
    $this->assertEquals(200, $responseWithoutCategoryId->status());

    $requestWithInvalidVideoId = Request::create("/api/atualizar-video", 'PUT', [
        'categoriaId' => '1',
        'titulo' => 'Meu vídeo',
        'descricao' => 'Descrição do vídeo',
        'url' => 'https://www.example.com/video'
    ]);

    $responseWithInvalidVideoId = $controller->update($requestWithInvalidVideoId, '100000000');
    $this->assertEquals(404, $responseWithInvalidVideoId->status());
    }

    public function testSearchVideos(){
        $controller = new VideoController();
        $request = Request::create('/api/buscar-videos?search=video', 'GET');
        $response = $controller->searchVideos($request);

        $this->assertEquals(200, $response->status());

        $requestNotFound = Request::create('/api/buscar-videos?search=categoria', 'GET');

        $responseNotFound = $controller->searchVideos($requestNotFound);

        $this->assertEquals(404, $responseNotFound->status());
    }


}
