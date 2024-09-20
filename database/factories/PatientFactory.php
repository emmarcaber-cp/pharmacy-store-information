<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition()
    {
        return [
            'doctor_id' => Doctor::factory()->create()->id,
            'name' => $this->faker->name,
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'address' => $this->faker->address,
            'contact_no' => $this->faker->phoneNumber,
        ];
    }

    /**
     * Configure the model factory to create a User automatically after a patient is created.
     */
    public function configure()
    {
        return $this->afterCreating(function (Patient $patient) {
            User::factory()->create([
                'name' => $patient->name,
                'auth_id' => $patient->id,
                'auth_type' => Patient::class,
                'email' => $this->faker->unique()->safeEmail,
                'password' => bcrypt('password'),
            ]);
        });
    }
}
