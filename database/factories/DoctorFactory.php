<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'specialty' => $this->faker->word,
        ];
    }

    /**
     * Configure the model factory to create a User automatically after a doctor is created.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Doctor $doctor) {
            User::factory()->create([
                'name' => $doctor->name,
                'auth_id' => $doctor->id,
                'auth_type' => Doctor::class,
                'email' => $this->faker->unique()->safeEmail,
                'password' => bcrypt('password'),
            ]);
        });
    }
}
