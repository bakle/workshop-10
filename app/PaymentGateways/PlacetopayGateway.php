<?php

namespace App\PaymentGateways;

use App\Models\Order;
use App\Models\Payment;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Str;

class PlacetopayGateway implements PaymentGatewayInterface
{
    private $gateway;

    private $id;

    private $processUrl;

    private $status;

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

        $this->id = $this->gateway->request($request)->requestId;
        $this->processUrl = $this->gateway->request($request)->processUrl;

        return $this;
    }

    public function getPaymentInformation(Payment $payment)
    {
        $response = $this->gateway->query($payment->request_id);

        $this->status = $payment->status_name;
        if ($response->isSuccessful()) {
            $this->status = $response->status()->status();
            return $this;
        }

        return null;
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
