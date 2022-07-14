<?php

namespace Database\Factories\Master;

use Illuminate\Database\Eloquent\Factories\Factory;

class BooksModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->city(),
            'description' => $this->faker->text,
            'photo' => $this->faker->imageUrl,
            'qty' => $this->faker->numberBetween(1, 100),
            'publisher' => $this->faker->company,
            'publish_year' => $this->faker->year,
            'author' => $this->faker->name,
            'created_by' => 1,
            'updated_by' => 1,
            'deleted_by' => 0,
        ];
    }
}