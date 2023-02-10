<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

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
        // Set faker to use the id_ID locale
        $this->faker->locale('id_ID');

        // Create a random category
        return [
            'name'          => $this->faker->unique()->word(3, true),
            'description'   => $this->faker->sentence(),
            'image'         => $this->faker->imageUrl(640, 480, 'product', true, null, true, 'png'),
            'price'         => $this->faker->randomFloat(2, 100, 1000),
            'quantity'      => $this->faker->numberBetween(1, 1000),
            'category_id'   => Category::all()->random()->id
        ];
    }
}
