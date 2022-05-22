@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Basket') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!session('basket'))
                        <p class="text-center">Nothing in your basket!</p>
                        @else
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
                                    @if (session('basket'))
                                        @foreach(session('basket') as $basket => $pizza)
                                            <tr>
                                                <td>{{ $pizza['name'] }}</td>
                                                <td>{{ $pizza['description'] }}</td>
                                                <td>{{ $pizza['size'] }}</td>
                                                <td>£{{ number_format($pizza['price'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <form action="/basket/clear" method="post">
                                    @csrf
                                    <Button class="btn btn-danger w-100">Clear Basket</Button>
                                </form>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Summary') }}</div>

                <?php
                    use App\Http\Controllers\BasketController;
                    use App\Http\Controllers\MenuController;
                    $totalCost = BasketController::getTotalCost();
                    $selectedDeal = MenuController::getSelectedDeal();
                ?>

                <div class="mt-3 ms-3">
                    @if($selectedDeal == "")
                        <p>Selected Deals: None</p>
                    @else
                        <p>Selected Deals: {{ $selectedDeal }}</p>
                    @endif
                </div>

                <form action="/orders/create" method="post">
                    @csrf
                    <div class="mt-2 ms-3">
                        <label for="getOrderType">Collection/Delivery</label>
                        <select name="getOrderType" id="getOrderType" class="form-select w-25" aria-label="Order retrieval type">
                            <option selected>...</option>
                            <option value="Collection">Collection</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == 1)
                            <div class="mt-2">
                                <strong style="color: red">{{ Session::get('error_message') }}</strong>
                            </div>
                        @endif
                    </div>

                    <h4 class="mt-4 ms-3">Total Cost: £{{ number_format($totalCost, 2) }}</h4>

                    <div class="text-center mb-3 mt-3">
                        @if (!session('basket'))
                            <Button class="btn btn-primary w-75" disabled>Confirm Order</Button>
                        @else
                            <Button class="btn btn-primary w-75">Confirm Order</Button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
