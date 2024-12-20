<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Firebase\JWT\JWT;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->userRepository);
    }

    public function testLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $this->actingAs($user);

        Config::set('app.secret', 'test_secret');

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $token = $response->json('token');

        $this->assertNotNull($token, 'O token JWT está vindo como null.');

        $decoded = JWT::decode($token, new \Firebase\JWT\Key('test_secret', 'HS256'));

        $response->assertStatus(200);
        $this->assertEquals($user->id, $decoded->sub);
    }



    public function testLoginWithInvalidCredentials()
    {
        Auth::shouldReceive('guard->attempt')
            ->once()
            ->with(['email' => '123@gmail.com', 'password' => '12345'])
            ->andReturn(false);

        $response = $this->postJson(
            '/api/login',
            [
                'email' => '123@gmail.com',
                'password' => '12345'
            ]
        );

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid credentials']);
    }
}
