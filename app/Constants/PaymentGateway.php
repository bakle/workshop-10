<?php


namespace App\Constants;


use App\PaymentGateways\Factory\PaymateGatewayFactory;
use App\PaymentGateways\Factory\PlacetopayGatewayFactory;

interface PaymentGateway
{
    public const PLACETOPAY = 'placetopay';
    public const PAYMATE = 'paymate';

    public const FACTORIES = [
        self::PLACETOPAY => PlacetopayGatewayFactory::class,
        self::PAYMATE => PaymateGatewayFactory::class,
    ];
}