@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">View Order - ID: {{ $order_id }}</div>

                <div class="card-body">
                    <div class="table-responsive pt-2">
                        <table class="table table-striped table-sm text-center align-middle">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Toppings</th>
                                <th scope="col">Size</th>
                                <th scope="col">Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(Auth::check())
                                @foreach($pizzas as $order)
                                    <tr>
                                        <td>{{ $order->pizza_name }}</td>
                                        <td>{{ $order->pizza_description }}</td>
                                        <td>{{ $order->pizza_size }}</td>
                                        <td>£{{ number_format($order->pizza_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('orders') }}" class="btn btn-primary w-100">Back To Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
