<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;


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
}
