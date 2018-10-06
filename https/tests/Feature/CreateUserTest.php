<?php

namespace Tests\Feature;

use App\Mail\ConfirmYourEmail;
use App\User;
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

    public function testUserHasTokenAfterRegistration()
    {
        Mail::fake();

        $this->post('/register', [

            'name' => 'new user',
            'email' => 'new_user@gmail.com',
            'password' => 'secret',

        ]);

        $user = User::find(1);

        $this->assertNotNull($user->confirm_token);
        $this->assertFalse($user->isConfirmed());

    }

    public function testConfirmUserToken()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->get("/register/confirm?token={$user->confirm_token}")
            ->assertRedirect('/');

        $this->assertTrue($user->fresh()->isConfirmed());
    }

}
