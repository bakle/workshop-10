<?php

namespace App\PaymentGateways\Factory;

use App\PaymentGateways\PaymateGateway;
use App\PaymentGateways\PaymentGatewayInterface;

class PaymateGatewayFactory extends PaymentGatewayFactory
{

    public function create(): PaymentGatewayInterface
    {
        return new PaymateGateway();
    }
}
