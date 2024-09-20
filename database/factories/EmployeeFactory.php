<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }

    /**
     * Configure the model factory to create a User automatically after a Employee is created.
     */
    public function configure()
    {
        return $this->afterCreating(function (Employee $employee) {
            User::factory()->create([
                'name' => $employee->name,
                'auth_id' => $employee->id,
                'auth_type' => Employee::class,
                'email' => $this->faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
            ]);
        });
    }
}
