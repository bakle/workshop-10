<?php


namespace App\PaymentGateways;


use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function pay(Order $order);

    public function getPaymentInformation(Payment $payment);

    public function id(): string;

    public function processUrl(): string;

    public function status(): string;
}