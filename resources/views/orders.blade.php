@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Orders') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!Auth::check())
                        @if (!session('orders'))
                            <p class="text-center">Nothing in your order history!</p>
                        @else
                            <p class="text-center">Please login to submit your orders to the kitchen!</p>
                            <div class="table-responsive pt-2 mt-3">
                                <table class="table table-striped table-sm text-center align-middle">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Collection/Delivery</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (session('orders'))
                                        @foreach(session('orders') as $orders => $order)
                                            <tr>
                                                <td>{{ $order['id'] }}</td>
                                                <td>{{ $order['type'] }}</td>
                                                <td>£{{ number_format($order['total'], 2) }}</td>
                                                <td>{{ $order['status'] }}</td>
                                                <td><a href="/orders/deletelocal/{{ $order['id'] }}" class="btn btn-danger w-100">Remove</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        @if(count($orders) == 0 or $orders == null)
                            <p class="text-center">Nothing in your order history!</p>
                        @else
                            <div class="table-responsive pt-2 mt-3">
                                <table class="table table-striped table-sm text-center align-middle">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Collection/Delivery</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->type }}</td>
                                            <td>£{{ number_format($order->total, 2) }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td><a href="/orders/view/{{ $order->id }}" class="btn btn-info w-100">View</a></td>
                                            <td><a href="/orders/delete/{{ $order->id }}" class="btn btn-danger w-100">Remove</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
