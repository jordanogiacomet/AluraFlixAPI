<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserModelTest extends TestCase
{
    /**
     * Testa a criação de um usuário.
     */
    public function testCreateUser()
    {
        // Dados de exemplo para criar um usuário
        $data = [
            'name' => 'User Test',
            'email' => fake()->safeEmail, // Gera um endereço de e-mail aleatório usando o Faker
            'password' => bcrypt('teste') // Criptografa a senha 'teste'
        ];

        // Criação do usuário utilizando o modelo User
        $user = User::create($data);

        // Verificação se o usuário foi criado corretamente e é uma instância de User
        $this->assertInstanceOf(User::class, $user);

        // Verificação se o usuário foi adicionado corretamente ao banco de dados
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * Testa a recuperação de um usuário por ID.
     */
    public function testRetrievedUser()
    {
        // Criação de um usuário de exemplo utilizando o Factory
        $user = User::factory()->create();

        // Recuperação do usuário utilizando o método find() do modelo User
        $retrievedUser = User::find($user->id);

        // Verificação se o usuário foi corretamente recuperado por ID
        $this->assertEquals($user->id, $retrievedUser->id);
    }
}
