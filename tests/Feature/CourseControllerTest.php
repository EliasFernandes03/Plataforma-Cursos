<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Http\Controllers\CourseController;
use App\Http\Requests\CreateCourseRequest;
use App\Repositories\CourseRepository;
use App\Http\Requests\UpdateCourseRequest;
use Mockery;
use Illuminate\Http\JsonResponse;

class CourseControllerTest extends TestCase
{
    protected $courseRepositoryMock;
    protected $courseController;

    protected function setUp(): void
    {
        parent::setUp();

        
        $this->courseRepositoryMock = Mockery::mock(CourseRepository::class);

        
        $this->courseController = new CourseController($this->courseRepositoryMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndexReturnsAllCourses()
    {
        $courses = [
            ['id' => 1, 'name' => 'Course 1', 'description' => 'Description 1'],
            ['id' => 2, 'name' => 'Course 2', 'description' => 'Description 2'],
        ];

        $this->courseRepositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn($courses);

        $response = $this->courseController->index();

        $this->assertInstanceOf(JsonResponse::class, $response);


        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals($courses, $response->getData(true));
    }

    public function testIndexReturnsCourse()
    {

        $courseId = 1;


        $course = [
            'id' => $courseId,
            'name' => 'Course 1',
            'description' => 'Description 1'
        ];


        $this->courseRepositoryMock
            ->shouldReceive('getOne')
            ->with($courseId)
            ->once()
            ->andReturn($course);


        $response = $this->courseController->show($courseId);


        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals($course, $response->getData(true));
    }

    public function testCreateController()
    {
        
        $courseData = [
            'name' => 'New Course',
            'description' => 'Course description'
        ];

        
        $requestMock = Mockery::mock(CreateCourseRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($courseData);

        
        $this->courseRepositoryMock
            ->shouldReceive('create')
            ->with($courseData)
            ->once();

        
        $response = $this->courseController->create($requestMock);

        
        $this->assertInstanceOf(JsonResponse::class, $response);

        
        $this->assertEquals(200, $response->getStatusCode());

        
        $this->assertEquals(['message' => ' Curso criado com sucesso'], $response->getData(true));
    }

    public function testUpdateController()
    {
        $courseId = 1;
    
        
        $courseData = [
            'name' => 'Updated Course',
            'description' => 'Updated description'
        ];
    
        
        $courseMock = Mockery::mock(\App\Models\Course::class);
        $courseMock->shouldReceive('getAttribute')->with('id')->andReturn($courseId);
    
       
        $requestMock = Mockery::mock(UpdateCourseRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($courseData);
    
       
        $this->courseRepositoryMock
            ->shouldReceive('getOne')
            ->with($courseId)
            ->once()
            ->andReturn($courseMock);
    
        $this->courseRepositoryMock
            ->shouldReceive('update')
            ->with($courseMock, $courseData)
            ->once();
    
        $response = $this->courseController->update($requestMock, $courseId);
    
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'usuario atualizado'], $response->getData(true));
    }
    
    public function testDeleteController()
    {
        $courseId = 1;
    
        $courseMock = Mockery::mock(\App\Models\Course::class);
        $courseMock->shouldReceive('getAttribute')->with('id')->andReturn($courseId);
    
        $this->courseRepositoryMock
            ->shouldReceive('getOne')
            ->with($courseId)
            ->once()
            ->andReturn($courseMock);
    
        $this->courseRepositoryMock
            ->shouldReceive('delete')
            ->with($courseMock)
            ->once();
    
        $response = $this->courseController->delete($courseId);
    
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals(['message' => 'Usuario deletado com sucesso'], $response->getData(true));
    }
    
}
