<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    //use RefreshDatabase;

    public function test_get_user_info()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('user.info'));

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cant_log_out(): void
    {
        $response = $this->postJson(route('auth.logout'));

        $response->assertStatus(401);
    }

    public function test_user_register_and_login()
    {
        $user = User::factory()->make();

        $registerParams = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson(route('auth.register'),$registerParams);

        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);

        $response->assertStatus(200);

        $loginPamrams = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $loginResponse = $this->postJson(route('auth.login'),$loginPamrams);

        $loginResponse->assertStatus(200);
    }  
}
