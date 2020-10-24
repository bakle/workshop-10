<?php

namespace App\PaymentGateways;

use App\Constants\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PaymateGateway implements PaymentGatewayInterface
{
    private $id;

    private $processUrl;

    private $status;


    public function pay(Order $order)
    {
        $this->id = rand(5, 7);
        $this->processUrl = route('paymate.create', ['order_id' => $order->id]);
        return $this;
    }

    public function getPaymentInformation(Payment $payment)
    {
        $this->status = Arr::random(PaymentStatus::STATUSES);
        return $this;
    }


    public function id(): string
    {
        return $this->id;
    }

    public function processUrl(): string
    {
        return $this->processUrl;
    }

    public function status(): string
    {
        return $this->status;
    }
}
