<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'image_url' => $this->faker->imageUrl()
        ];
    }
}
