<?php

namespace Database\Factories\Master;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'book_id' => $this->faker->numberBetween(1, 10),
            'borrow_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'return_date' => $this->faker->randomElement([Carbon::createFromDate($this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'))->addDays($this->faker->numberBetween(1, 30)), null]),
        ];
    }
}