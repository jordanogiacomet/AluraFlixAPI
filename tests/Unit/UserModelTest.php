<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserModelTest extends TestCase
{
    public function testCreateUser(){
        $data = [
            'name' => 'User Test',
            'email' => fake()->safeEmail,
            'password' =>   bcrypt('teste') 
        ];

        $user = User::create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', $data);

    }


    public function testRetrievedUser(){
        $user = User::factory()->create();

        $retrievedUser = User::find($user->id);

        $this->assertEquals($user->id, $retrievedUser->id);
    }

}
