<?php

namespace App\PaymentGateways\Factory;

use App\PaymentGateways\PaymentGatewayInterface;
use App\PaymentGateways\PlacetopayGateway;

class PlacetopayGatewayFactory extends PaymentGatewayFactory
{

    public function create(): PaymentGatewayInterface
    {
        return new PlacetopayGateway();
    }
}
