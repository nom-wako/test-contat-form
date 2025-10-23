<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\Category;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $prefecture = $this->faker->prefecture();
        $city = $this->faker->city();
        $street = $this->faker->streetAddress();
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->numberBetween(1, 3),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->numerify('###########'),
            'address' => "{$prefecture}{$city}{$street}",
            'building' => $this->faker->optional()->secondaryAddress(),
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'detail' => $this->faker->realText(120),
            'created_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
            'updated_at' => now(),
        ];
    }
}
