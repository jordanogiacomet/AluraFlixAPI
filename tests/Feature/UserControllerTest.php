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
    


    public function testRegister(){
       
        
        $controller = new UserController();

        $request = Request::create('/api/register', 'POST', [
            'name' => 'test-user',
            'email' => 'test@test',
            'password' => 'test'
        ]);


        $response = $controller->register($request);

        $this->assertEquals(200, $response->status());

    }


    public function testLogin(){
        
        $response = $this->post('/api/login', [
            'name' => 'test-user',
            'password' => 'test',
        ]);

        $response->assertStatus(200);

        $responseWithValidationError = $this->post('/api/login', [
            'name' => 'test-user'
        ]);

        $responseWithValidationError->assertStatus(422);

        $responseWithWrongCredentials = $this->post('/api/login', [
            'name' => 'error-test',
            'password' => 'error'
        ]);
    
        $responseWithWrongCredentials->assertStatus(404);
    }


    public function testLogout(){
       
        $response = $this->post('/api/logout');
        $response->assertStatus(200);
    }
}
