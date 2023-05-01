<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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
    public function definition(): array
    {
        return [
            'name'=>$this->faker->text(17),
            'description'=>$this->faker->text(170),
            'category_id'=>Category::factory(1)->create()->first()->id,
            'user_id'=>User::factory(1)->create()->first()->id,
        ];
    }
}
