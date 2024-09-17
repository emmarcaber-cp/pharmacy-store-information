<?php

namespace Database\Factories;

use App\Models\DrugManufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drug>
 */
class DrugFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trade_name' => $this->faker->word,
            'drug_manufacturer_id' => DrugManufacturer::factory()->create()->company_id,
        ];
    }
}
