<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Response;
use Tests\TestCase;
use Mockery;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepositoryMock;
    protected $userController;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->userController = new UserController($this->userRepositoryMock);
    }

    public function testReturnAllUsers()
    {
        $users = User::factory()->count(3)->make();
        $this->userRepositoryMock->shouldReceive('all')->once()->andReturn($users);

        $response = $this->userController->index();
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals($users->toArray(), $response->getData(true));
    }

    public function testReturnOneUser()
    {
        $user = User::factory()->make(['id' => 1]);
        $this->userRepositoryMock->shouldReceive('getOne')->with(1)->once()->andReturn($user);

        $response = $this->userController->show(1);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals($user->toArray(), $response->getData(true));
    }

    public function testCreateNewUser()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];


        $request = Mockery::mock(CreateUserRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $this->userRepositoryMock->shouldReceive('create')->with($data)->once();

        $response = $this->userController->create($request);

        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals(['message' => 'Usuario Criado Com sucesso'], $response->getData(true));
    }

    public function testUpdateExistingUser()
    {
        $user = User::factory()->make(['id' => 1]);
        $data = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'password' => 'newpassword123',
        ];

        $request = Mockery::mock(UpdateUserRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $this->userRepositoryMock->shouldReceive('getOne')->with(1)->once()->andReturn($user);
        $this->userRepositoryMock->shouldReceive('update')->with($user, $data)->once();

        $response = $this->userController->update($request, 1);

        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals(['message' => 'Usuario Atualizado Com sucesso'], $response->getData(true));
    }

    public function testDeleteRemovesUser()
    {
        $user = User::factory()->make(['id' => 1]);
        $this->userRepositoryMock->shouldReceive('getOne')->with(1)->once()->andReturn($user);
        $this->userRepositoryMock->shouldReceive('delete')->with($user)->once();

        $response = $this->userController->delete(1);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
    }
}
