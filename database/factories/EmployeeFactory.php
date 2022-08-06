<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Employee::class;


    public function definition()
    {
        return [
            'id' => $this->faker->randomNumber(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email_address' => $this->faker->unique()->email(),
            'contacts' => [],
            'state' => $this->faker->country(),
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'status' => 'active',
            'zip' => 42000
        ];
    }
}
