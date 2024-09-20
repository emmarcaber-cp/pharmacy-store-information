<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
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
            'address' => $this->faker->address(),
            'fax' => $this->faker->phoneNumber(),
        ];
    }

    /**
     * Configure the model factory to create a User automatically after a pharmacy is created.
     */
    public function configure()
    {
        return $this->afterCreating(function (Pharmacy $pharmacy) {
            User::factory()->create([
                'name' => $pharmacy->name,
                'auth_id' => $pharmacy->id,
                'auth_type' => Pharmacy::class,
                'email' => $this->faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
            ]);
        });
    }
}
