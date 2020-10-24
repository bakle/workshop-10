<?php

namespace App\PaymentGateways;

use App\Models\Order;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Str;

class PlacetopayGateway
{
    private $gateway;

    public function __construct()
    {

        $this->gateway = new Placetopay([
            'login' => config('payment-gateways.placetopay.login'),
            'tranKey' => config('payment-gateways.placetopay.trankey'),
            'url' => config('payment-gateways.placetopay.url'),
            'rest' => [
                'timeout' => 45, // (optional) 15 by default
                'connect_timeout' => 30, // (optional) 5 by default
            ]
        ]);
    }

    public function pay(Order $order)
    {
        $request = [
            'payment' => [
                'reference' => $order->id,
                'description' => Str::uuid()->toString(),
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->total_price,
                ],
            ],
            'expiration' => date('c', strtotime(' + 2 days')),
            'returnUrl' => route('orders.show', $order->id),
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent()
        ];

        return $this->gateway->request($request);
    }
}
