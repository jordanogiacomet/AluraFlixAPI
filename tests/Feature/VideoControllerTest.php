<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\VideoController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoControllerTest extends TestCase
{
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
        $request = Request::create("/api/criar", 'POST', [
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
            'titulo' => 'Meu vídeo',
            'descricao' => 'Descrição do vídeo',
            'url' => 'https://www.example.com/video'
        ]);
    } 
    
    public function testDestroy()
{
    // Define o ID do vídeo a ser deletado
    $id = '2';

    // Faz uma requisição GET para a rota '/api/deletar/{$id}'
    $response = $this->delete("/api/deletar/{$id}");

    // Verifica se o status da resposta é 200 (OK)
    $this->assertEquals(200, $response->status());
}


public function testUpdate()
{
    // Criação de uma instância do controlador
    $controller = new VideoController();

    // Definição do ID do vídeo a ser atualizado
    $id = '2';

    // Criação de um objeto de requisição simulada para a rota '/api/criar' com método POST e dados de exemplo
    $request = Request::create("/api/criar", 'POST', [
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
        'titulo' => 'Meu vídeo',
        'descricao' => 'Descrição do vídeo',
        'url' => 'https://www.example.com/video'
    ]);
}

}
