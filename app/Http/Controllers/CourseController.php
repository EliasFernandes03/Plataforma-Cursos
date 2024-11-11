<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    protected $couseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->couseRepository = $courseRepository;
    }

    public function index()
    {
        $courses = $this->couseRepository->all();
        return response()->json($courses, 200);
    }

    public function show($id)
    {
        $couse = $this->couseRepository->getOne($id);
        return response()->json($couse, 200);
    }

    public function create(CreateCourseRequest $request)
    {
        $data = $request->validated();
        $this->couseRepository->create($data);
        return response()->json(['message' => ' Curso criado com sucesso'], 200);
    }

    public function update(UpdateCourseRequest $request, int $id)
    {
        $course = $this->couseRepository->getOne($id);
        $data = $request->validated();
        $this->couseRepository->update($course, $data);
        return response()->json(['message' => 'usuario atualizado'], 200);
    }

    public function delete(int $id)
    {
        $course = $this->couseRepository->getOne($id);
        $this->couseRepository->delete($course);
        return response()->json(['message' => 'Usuario deletado com sucesso'], 204);
    }
}
