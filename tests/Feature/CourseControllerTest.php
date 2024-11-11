<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\CourseController;
use App\Repositories\CourseRepository;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\JsonResponse;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;

class CourseControllerTest extends TestCase
{
    use WithFaker;

    protected $courseRepository;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->courseRepository = Mockery::mock(CourseRepository::class);
        $this->controller = new CourseController($this->courseRepository);
    }

    public function testIndex()
    {
        $courses = [
            ['id' => 1, 'name' => 'Curso 1'],
            ['id' => 2, 'name' => 'Curso 2'],
        ];

        $this->courseRepository->shouldReceive('all')->once()->andReturn($courses);

        $response = $this->controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($courses, $response->getData(true));
    }

    public function testShow()
    {
        $course = ['id' => 1, 'name' => 'Curso 1'];

        $this->courseRepository->shouldReceive('getOne')->with(1)->once()->andReturn($course);

        $response = $this->controller->show(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($course, $response->getData(true));
    }

    public function testCreate()
    {
        $data = ['name' => 'Novo Curso'];
        $request = new CreateCourseRequest();
        $request->replace($data);

        $this->courseRepository->shouldReceive('create')->with($data)->once();

        $response = $this->controller->create($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => ' Curso criado com sucesso'], $response->getData(true));
    }

    public function testUpdate()
    {
        $course = ['id' => 1, 'name' => 'Curso Atual'];
        $data = ['name' => 'Curso Atualizado'];
        $request = new UpdateCourseRequest();
        $request->replace($data);

        $this->courseRepository->shouldReceive('getOne')->with(1)->once()->andReturn($course);
        $this->courseRepository->shouldReceive('update')->with($course, $data)->once();

        $response = $this->controller->update($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'usuario atualizado'], $response->getData(true));
    }

    public function testDelete()
    {
        $course = ['id' => 1, 'name' => 'Curso a ser deletado'];

        $this->courseRepository->shouldReceive('getOne')->with(1)->once()->andReturn($course);
        $this->courseRepository->shouldReceive('delete')->with($course)->once();

        $response = $this->controller->delete(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals(['message' => 'Usuario deletado com sucesso'], $response->getData(true));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
