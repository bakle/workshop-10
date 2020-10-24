<?php

namespace App\Http\Controllers\Api;

use App\Constants\OrderStatus;
use App\Constants\PaymentGateway;
use App\Constants\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Models\Payment;
use App\PaymentGateways\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return PaymentResource
     */
    public function store(Request $request)
    {
        $order = Order::find($request->input('order_id'));

        $paymentGatewayClass = PaymentGateway::FACTORIES[$request->input('payment_gateway')];

        $paymentGateway = (new $paymentGatewayClass())->create();

        $response = $paymentGateway->pay($order);

        $payment = $this->savePayment($order, $response, $request->input('payment_gateway'));

        return new PaymentResource($payment);
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $payment
     * @return PaymentResource
     */
    public function show(Payment $payment): PaymentResource
    {
        $paymentGatewayClass = PaymentGateway::FACTORIES[$payment->gateway];

        $paymentGateway = (new $paymentGatewayClass())->create();

        $response = null;
        if ($payment->isPending()) {
            $response = $paymentGateway->getPaymentInformation($payment);
        }

        if (!$response || PaymentStatus::isPending($response->status())) {
            return new PaymentResource($payment);
        }

        $status = Str::lower($response->status());
        $payment->status = array_flip(PaymentStatus::STATUSES)[$status];

        if (PaymentStatus::isApproved($status)) {
            $payment->paid_at = now();
            $payment->order->status = OrderStatus::PAID;
        }

        $payment->save();

        return new PaymentResource($payment);
    }

    private function savePayment(Order $order, PaymentGatewayInterface $paymentGateway, string $gateway): Payment
    {
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->gateway = $gateway;
        $payment->reference = Str::uuid()->toString();
        $payment->request_id = $paymentGateway->id();
        $payment->process_url = $paymentGateway->processUrl();
        $payment->currency = 'COP';
        $payment->total_paid = $order->total_price;
        $payment->status = PaymentStatus::PENDING;
        $payment->save();

        return $payment;
    }
}
