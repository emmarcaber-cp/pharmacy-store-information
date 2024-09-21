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
}
