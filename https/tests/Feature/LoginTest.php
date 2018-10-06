<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [

            'email' => $user->email,
            'password' => 'secret',

        ])
            ->assertStatus(200)
            ->assertJson([

                'status' => 'ok'

            ])
            ->assertSessionHas('success', 'Successfully logged in');
    }

    public function test_user_can_see_validation_error_message_when_passing_in_wrong_credentials()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [

            'email' => $user->email,
            'password' => 'wrong password',

        ])->assertStatus(422)
            ->assertJson([

                'message' => 'These credentials do not match our records.',

            ]);
    }
}
