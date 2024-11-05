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


}
