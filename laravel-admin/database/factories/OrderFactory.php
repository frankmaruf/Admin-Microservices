<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'canceled']),
            'payment_id' => $this->faker->uuid,
            'payment_amount' => $this->faker->randomFloat(2, 0, 100),
            'payment_currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            'payment_description' => $this->faker->sentence,
            'payment_status_detail' => $this->faker->randomElement(['pending', 'paid', 'failed', 'canceled']),
            'payment_created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'payment_updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'payment_transaction_id' => $this->faker->uuid,
            'payment_transaction_type' => $this->faker->randomElement(['authorize', 'capture', 'refund']),
            'payment_transaction_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'canceled']),
            'payment_transaction_amount' => $this->faker->randomFloat(2, 0, 100),
            'payment_transaction_currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            
        ];
    }
}
