<?php

namespace App\Repositories;

use App\Models\Course;


class CourseRepository
{
    public function all()
    {
        return Course::all();
    }

    public function getOne($id)
    {
        return Course::findOrFail($id);
    }

    public function create($data)
    {
        return Course::create($data);
    }
}
