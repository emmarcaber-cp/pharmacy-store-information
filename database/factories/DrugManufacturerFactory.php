<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\DrugManufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DrugManufacturer>
 */
class DrugManufacturerFactory extends Factory
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
        ];
    }

    /**
     * onfigure the model factory to create a User automatically after a drug manufacturer is created.
     */
    public function configure()
    {
        return $this->afterCreating(function (DrugManufacturer $drugManufacturer) {
            User::factory()->create([
                'name' => $drugManufacturer->name,
                'auth_id' => $drugManufacturer->id,
                'auth_type' => DrugManufacturer::class,
                'email' => $this->faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
            ]);
        });
    }
}
