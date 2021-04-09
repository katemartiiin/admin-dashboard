<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst(trans($this->faker->words(2, true))),
            'category' => ucfirst(trans($this->faker->word)),
            'description' => $this->faker->sentence,
            'created_by' => $this->faker->userName,
            'date_time' =>  date('now'),
        ];
    }
}
