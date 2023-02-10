<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Set faker to use the id_ID locale
        $this->faker->locale('id_ID');

        // Create a random category
        return [
            'name'          => $this->faker->unique()->word(3, true),
            'description'   => $this->faker->sentence()
        ];
    }
}
