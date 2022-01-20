<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstname(),
            'last_name' => $this->faker->lastname(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'address1' => $this->faker->address(),
            'address2' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->randomNumber(5),
            'card_number' => $this->faker->numberBetween(1111111111, 9999999999),
            'expired' => $this->faker->randomNumber(4),
            'cvv' => $this->faker->randomNumber(3),
            'updated_at' => now(),
        ];
    }
}
