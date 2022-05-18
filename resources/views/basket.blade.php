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
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (session('basket'))
                                        @foreach(session('basket') as $id => $pizza)
                                            <tr>
                                                <td>{{ $pizza['name'] }}</td>
                                                <td>{{ $pizza['description'] }}</td>
                                                <td>{{ $pizza['size'] }}</td>
                                                <td>£{{ number_format($pizza['price'], 2) }}</td>
                                                <td><a href="/basket/delete/{{ $pizza['pizza_id'] }}" class="btn btn-danger">Remove</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
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

                <div class="mt-3 ms-3">
                    <label for="getOrderTypes">Collection/Delivery</label>
                    <select id="getOrderTypes" class="form-select w-25" aria-label="Order retrieval type">
                        <option selected>...</option>
                        <option value="collection">Collection</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>

                <?php
                    use App\Http\Controllers\MenuController;
                    $totalCost = MenuController::getTotalCost();
                ?>

                <h3 class="mt-4 ms-3">Total Cost: £{{ number_format($totalCost, 2) }}</h3>

                <div class="text-center mb-3 mt-3">
                    <form action="">
                        <Button class="btn btn-primary w-75">Confirm Order</Button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
