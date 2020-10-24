<?php

namespace App\PaymentGateways\Factory;

use App\PaymentGateways\PaymentGatewayInterface;

abstract class PaymentGatewayFactory
{
    abstract public function create(): PaymentGatewayInterface;
}
