<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Http\Requests\CreateCourseRequest;

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
        return response()->json($courses);
    }

    public function show($id)
    {
        $couse = $this->couseRepository->getOne($id);
        return response()->json($couse);
    }

    public function create(CreateCourseRequest $request)
    {
        $data = $request->validated();
        $this->couseRepository->create($data);
        return response()->json(['message' => ' Curso criado com sucesso']);
    }
}
