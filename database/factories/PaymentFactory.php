<?php

namespace Database\Factories;

use App\Constants\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'reference' => $this->faker->uuid,
            'request_id' => $this->faker->numberBetween(10000, 100000),
            'status' => $this->faker->randomElement([
                PaymentStatus::FAILED, PaymentStatus::APPROVED, PaymentStatus::DECLINED, PaymentStatus::PENDING
            ]),
            'currency' => $this->faker->currencyCode,
            'total_paid' => $this->faker->numberBetween(10000, 100000),
        ];
    }
}
