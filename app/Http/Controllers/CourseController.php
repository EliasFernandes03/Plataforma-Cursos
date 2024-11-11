<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        $courses = $this->courseRepository->all();
        return response()->json($courses, 200);
    }

    public function show($id)
    {
        $couse = $this->courseRepository->getOne($id);
        return response()->json($couse, 200);
    }

    public function create(CreateCourseRequest $request)
    {
        $data = $request->validated();
        $this->courseRepository->create($data);
        return response()->json(['message' => ' Curso criado com sucesso'], 200);
    }

    public function update(UpdateCourseRequest $request, int $id)
    {
        $course = $this->courseRepository->getOne($id);
        $data = $request->validated();
        $this->courseRepository->update($course, $data);
        return response()->json(['message' => 'usuario atualizado'], 200);
    }

    public function delete(int $id)
    {
        $course = $this->courseRepository->getOne($id);
        $this->courseRepository->delete($course);
        return response()->json(['message' => 'Usuario deletado com sucesso'], 204);
    }
}
