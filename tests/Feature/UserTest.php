<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

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
        $faker = \Faker\Factory::create();

        $registerParams = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => 'password'
        ];

        $response = $this->postJson(route('auth.register'),$registerParams);

        $response->assertStatus(200);

        $loginPamrams = [
            'email' => $registerParams['email'],
            'password' => 'password'
        ];

        $loginResponse = $this->postJson(route('auth.login'),$loginPamrams);

        $loginResponse->assertStatus(200);
    }  
}
