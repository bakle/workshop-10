@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-10 offset-1 p-4 border rounded-lg">
            <div class="row text-black-50 mb-3 border-bottom">
                <div class="col-6">
                    <h1 class="h4 mr-2 d-inline-block">
                        Order #{{ $order->id }}
                    </h1>
                    <span class="badge badge-pill badge-primary">{{ $order->status() }}</span>
                </div>
                <div class="col-6 text-right">
                    {{ $order->created_at->toFormattedDateString() }}
                </div>
            </div>
            <div class="row">
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->details as $detail)
                        <tr>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>${{ $detail->unit_price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    <div class="text-right text-info">
                        <strong>Total: </strong>
                        <span>${{ $order->total_price }}</span>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center text-black-50 h4">Pay with</h3>
                </div>
                <div class="col-12 my-3 text-center">
                    <button
                        data-payment-gateway="{{ \App\Constants\PaymentGateway::PAYMATE }}"
                        class="btn btn-outline-secondary"
                    >
                        @svg('pay-mate', 'w-50')
                    </button>
                    <button
                        class="btn btn-dark"
                        data-payment-gateway="{{ \App\Constants\PaymentGateway::PLACETOPAY }}"
                    >
                        @svg('placetopay', 'w-50')
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-10 offset-1 p-4 border rounded-lg">
            <div class="row text-black-50 mb-3 border-bottom">
                <div class="col-12">
                    <h2 class="text-black-50 h4">Transactions</h2>
                </div>
            </div>
            <div class="row">
                <table class="table table-light">
                    <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Created at</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ \Illuminate\Support\Str::uuid()->toString() }}</td>
                        <td>{{ \App\Constants\PaymentStatus::STATUSES[0] }}</td>
                        <td>{{ now()->toDateTimeString() }}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection