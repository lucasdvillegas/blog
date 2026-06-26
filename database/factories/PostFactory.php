<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{

    public function definition(): array
    {

        return [

            'title' => fake()->word(),
            'description' => fake()->word(),
            'content' => fake()->sentence(),
            'active' => fake()->boolean(),
            'slug' => fake()->word(),

        ];
    }
}
