<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->name(),
            'product_price' => $this->faker->randomFloat(2, 0, 100),
            'qty' => $this->faker->randomFloat(2, 0, 100),
            'product_description' => $this->faker->sentence(),
            'product_category' => $this->faker->numberBetween(1, 8),          
            'status' => '1', 
            'product_image' => $this->faker->imageUrl(), 
            'shipping_cost' => $this->faker->randomFloat(2, 3, 5), 
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('now'),           
        ];
    }
}
