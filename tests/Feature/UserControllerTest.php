<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Mockery;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->userRepositoryMock);
    }

    public function testReturnAllUsers()
    {
        $users = User::factory()->count(3)->make();
        $this->userRepositoryMock->shouldReceive('all')->once()->andReturn($users);
        $response = $this->getJson('/api/users');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($users->toArray());
    }

    public function testReturnOneUser()
    {
        $user = User::factory()->make(['id' => 1]);
        $this->userRepositoryMock->shouldReceive('getOne')->with(1)->once()->andReturn($user);
        $response = $this->getJson('/api/users/1');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($user->toArray());
    }

    public function testCreateNewUser()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];
        $this->userRepositoryMock->shouldReceive('create')->with($data)->once();
        $response =  $this->postJson('/api/users/create', $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Usuario Criado Com sucesso']);
    }

    public function updateExistingUser()
    {
        $user = User::factory()->make(['id' => 1]);
        $data = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'password' => 'newpassword123',
        ];
        $this->userRepositoryMock->shouldReceive('getOne')->with(1)->once()->andReturn($user);
        $this->userRepositoryMock->shouldReceive('update')->with($user, $data)->once();

        $response = $this->putJson('/api/users/update/1', $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Usuario Atualizado Com sucesso']);
    }

    public function testDeleteRemovesUser()
    {
        $user = User::factory()->make(['id' => 1]);
        $this->userRepositoryMock->shouldReceive('getOne')->with(1)->once()->andReturn($user);
        $this->userRepositoryMock->shouldReceive('delete')->with($user)->once();

        $response = $this->deleteJson('/api/users/delete/1');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

}
