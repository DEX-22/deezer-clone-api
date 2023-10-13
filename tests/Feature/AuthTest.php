<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_can_register()
    {
        $userData = $this->getValidUserData();

        $response = $this->post('/api/register', $userData);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_user_can_login_after_register()
    {
        $userData = $this->getValidUserData();
        $this->post('/api/register', $userData);

        $loginData = [
            'email' => $userData['email'],
            'password' => $userData['password'],
        ];

        $response = $this->post('/api/login', $loginData);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['user', 'token']);
    }

    public function test_user_can_logout_after_login()
    {
        $userData = $this->getValidUserData();
        $this->post('/api/register', $userData);

        $token = $this->getLoginToken($userData);

        $response = $this->withTokenHeader($token)->post('/api/logout');

        $response->assertStatus(200);
    }

    public function test_user_cannot_logout_twice_with_the_same_token()
    {
        $userData = $this->getValidUserData();
        $this->post('/api/register', $userData);

        $token = $this->getLoginToken($userData);

        $response = $this->withTokenHeader($token)->post('/api/logout');

        $response->assertStatus(200);

        $response = $this->withTokenHeader($token)->post('/api/logout');

        $response->assertStatus(401);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $userData = $this->getValidUserData();
        $this->post('/api/register', $userData);

        $invalidLoginData = [
            'email' => $userData['email'],
            'password' => 'invalid_password',
        ];

        $response = $this->post('/api/login', $invalidLoginData);

        $response->assertStatus(401);
    }

    public function test_user_cannot_login_with_nonexistent_email()
    {
        $nonexistentLoginData = [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $nonexistentLoginData);

        $response->assertStatus(401);
    }

    private function getValidUserData()
    {
        return [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'password' => 'password',
            'country' => 'Country Name',
        ];
    }

    private function getLoginToken($userData)
    {
        $response = $this->post('/api/login', [
            'email' => $userData['email'],
            'password' => $userData['password'],
        ]);

        $data = $response->json();

        return $data['token'];
    }

    private function withTokenHeader($token)
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }
}
