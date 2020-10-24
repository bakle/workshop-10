@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-10 offset-1 p-4 border rounded-lg">
            <div class="row">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a></td>
                            <td>{{ $order->status_name }}</td>
                            <td>${{ $order->total_price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection