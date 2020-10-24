<?php

namespace App\Http\Controllers\Api;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Models\Payment;
use App\PaymentGateways\PlacetopayGateway;
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
        $placetopay = new PlacetopayGateway();
        $response = $placetopay->pay($order);

        $payment = $this->savePayment(new Payment(), $order, $response);

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
        $placetopay = new PlacetopayGateway();

        $response = null;
        if ($payment->isPending()) {
            $response = $placetopay->getPaymentInformation($payment);
        }

        if (!$response || PaymentStatus::isPending($response->status()->status())) {
            return new PaymentResource($payment);
        }

        $status = Str::lower($response->status()->status());
        $payment->status = array_flip(PaymentStatus::STATUSES)[$status];

        if (PaymentStatus::isApproved($status)) {
            $payment->paid_at = now();
            $payment->order->status = OrderStatus::PAID;
        }

        $payment->save();

        return new PaymentResource($payment);
    }

    private function savePayment(Payment $payment, Order $order, $response): Payment
    {
        $payment->order_id = $order->id;
        $payment->reference = Str::uuid()->toString();
        $payment->request_id = $response->requestId;
        $payment->process_url = $response->processUrl;
        $payment->currency = 'COP';
        $payment->total_paid = $order->total_price;
        $payment->save();

        return $payment;
    }
}
