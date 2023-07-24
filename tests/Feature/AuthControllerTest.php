<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    public function testRegistration()
    {
        $user = [
            'email' => 'test@example.com',
            'password' => 'testpassword',
        ];

        $response = $this->post('/api/register', $user);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Registration successful']);
    }

    public function testLoginWithValidCredentials()
    {
        $user = User::factory()->create(['password' => bcrypt('testpassword')]);

        $credentials = [
            'email' => $user->email,
            'password' => 'testpassword',
        ];

        $response = $this->post('/api/login', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function testLoginWithInvalidCredentials()
    {
        $credentials = [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ];

        $response = $this->post('/api/login', $credentials);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid login credentials']);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->actingAs($user)->post('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out']);
    }
}
