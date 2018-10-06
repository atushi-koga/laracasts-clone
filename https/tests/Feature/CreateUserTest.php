<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $userName = 'test user';
        $userEmail = 'test@gmail.com';
        $userPassword = 'secret';

        $this->post('/login',[

            'name' => $userName,
            'email' => $userEmail,
            'password' => $userPassword,

        ])
        ->assertRedirect('/home');

        $this->assertDatabaseHas('users', [

            'name' => $userName,

        ]);


    }
}
