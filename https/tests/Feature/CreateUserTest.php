<?php

namespace Tests\Feature;

use App\Mail\ConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
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

        $this->post('/register', [

            'name' => $userName,
            'email' => $userEmail,
            'password' => $userPassword,

        ])
            ->assertRedirect('/home');

        $this->assertDatabaseHas('users', [

            'name' => $userName,

        ]);
    }

    public function testAnEmailIsSentToNewlyRegisteredUser()
    {
        Mail::fake();

        $this->post('/register', [

            'name' => 'new user',
            'email' => 'new_user@gmail.com',
            'password' => 'secret',

        ])
            ->assertRedirect('/home');

        Mail::assertSent(ConfirmYourEmail::class);
    }
}
