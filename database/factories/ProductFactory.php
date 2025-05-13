<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'img_path' => $this->faker->imageUrl(),
            'name' => $this->faker->realText(10),
            'kakaku' => $this->faker->numberBetween(50, 999),
            'zaiko' => $this->faker->numberBetween(1, 999),
            'maker' => $this->faker->numberBetween(1, 3),
            'syousai' => $this->faker->realText(20),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];
    }
}
